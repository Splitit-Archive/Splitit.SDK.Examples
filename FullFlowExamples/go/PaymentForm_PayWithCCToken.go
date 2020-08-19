package payWithToken

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

var apiClient = splitit.NewSandboxAPIClient(
	"apiKey",
	"username",
	"password",
)

// For a returning shopper, use an existing plan that is related to that shopper
func GetCCToken(ctx context.Context, oldInstallmentPlanNo string) (ccToken string, err error) {
	prevInstPlan, _, err := apiClient.InstallmentPlanApi.InstallmentPlanGet(ctx, splitit.GetInstallmentsPlanSearchCriteriaRequest{
		QueryCriteria: &splitit.InstallmentPlanQueryCriteria{
			InstallmentPlanNumber: oldInstallmentPlanNo,
		},
	})
	if err != nil || len(prevInstPlan.PlansList) == 0 {
		return "", fmt.Errorf("Can't get the previous installment plan: %w", err)
	}

	return prevInstPlan.PlansList[0].ActiveCard.Token, err
}

// Set a new installment plan for the returning shopper
func InitializeNewPlan() (newPlanNumber string, err error) {
	ctx := context.TODO()

	transactionValue := 300.0

	// TODO: Fill-in the data
	initPaymentResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanInitiate(
		ctx,
		splitit.InitiateInstallmentPlanRequest{
			PlanData: &splitit.PlanData{
				AutoCapture:          true,
				Amount:               &splitit.MoneyWithCurrencyCode{transactionValue, "USD"},
				NumberOfInstallments: 3,
				RefOrderNumber:       "abc123",
			},
			BillingAddress: &splitit.AddressData{
				AddressLine: "260 Madison Avenue.",
				City:        "New York",
				State:       "NY",
				Country:     "USA",
				Zip:         "10016",
			},
			ConsumerData: &splitit.ConsumerData{
				FullName:    "John Smith",
				Email:       "JohnS@splitit.com",
				PhoneNumber: "1-415-775-4848",
				CultureName: "en-us",
			},
		},
	)
	if err != nil {
		err = fmt.Errorf("InstallmentPlanInitiate call failed: %w", err)
		return
	}

	return initPaymentResp.InstallmentPlan.InstallmentPlanNumber, nil
}

// Create the installment plan using Credit Card Token
func PayWithToken(newPlanNumber string, ccToken string) (err error) {
	ctx := context.TODO()
	transactionValue := 300.0

	_, _, err = apiClient.InstallmentPlanApi.InstallmentPlanCreate(
		ctx,
		splitit.CreateInstallmentPlanRequest{
			InstallmentPlanNumber: newPlanNumber,
			PlanData: &splitit.PlanData{
				Amount: &splitit.MoneyWithCurrencyCode{transactionValue, "USD"},
			},
			// Use credit card from previous payment
			PaymentToken: &splitit.PaymentToken{
				Token: ccToken,
				Type:  "SplititStoredCard",
			},
		},
	)

	if err != nil {
		return fmt.Errorf("InstallmentPlanInitiate call failed: %w", err)
	}

	return nil
}
