package depositFutureDate

import (
	"context"
	"errors"
	"fmt"
	"time"

	"github.com/splitit/splitit.sdks.go"
)

var apiClient = splitit.NewSandboxAPIClient(
	"apiKey",
	"username",
	"password",
)

// TODO: Use as a handler for Checkout request
func InitiateInstallmentPlan(transactionValue float64) (err error) {
	ctx := context.TODO()

	// TODO: Customize the data
	initPaymentResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanInitiate(
		ctx,
		splitit.InitiateInstallmentPlanRequest{
			PlanData: &splitit.PlanData{
				AutoCapture:          true,
				Amount:               &splitit.MoneyWithCurrencyCode{transactionValue, "USD"},
				NumberOfInstallments: 3,
				RefOrderNumber:       "abc123",
				// Request 50% of the transaction as a first installment
				FirstInstallmentAmount: &splitit.MoneyWithCurrencyCode{0.5 * transactionValue, "USD"},
				// Delay first charge for a week
				FirstChargeDate: splitit.NewSplititTime(time.Now().Add(7 * 24 * time.Hour)),
			},
			PaymentWizardData: &splitit.PaymentWizardData{
				RequestedNumberOfInstallments: "2,3,4,5,6",
			},
			// Optional data to pre-fill the form
			BillingAddress: &splitit.AddressData{
				AddressLine: "260 Madison Avenue.",
				City:        "New York",
				State:       "NY",
				Country:     "USA",
				Zip:         "10016",
			},
			// Optional data to pre-fill the form
			ConsumerData: &splitit.ConsumerData{
				FullName:    "John Smith",
				Email:       "JohnS@splitit.com",
				PhoneNumber: "1-415-775-4848",
				CultureName: "en-us",
			},
			// After user successfully interacts with splitit.com they would be
			// redirected to provided Succeeded URL with InstallmentPlanNumber as
			// a parameter in GET request. It is required to continue the flow.
			RedirectUrls: &splitit.RedirectUrls{
				Succeeded: "http://localhost/Succeeded",
				Canceled:  "http://localhost/Canceled",
				Failed:    "http://localhost/Failed",
			},
		},
	)
	if err != nil {
		return fmt.Errorf("InstallmentPlanInitiate call failed: %w", err)
	}

	// TODO: Redirect customer to initPaymentResp.CheckoutUrl
	fmt.Printf("Go to %s\n\n", initPaymentResp.CheckoutUrl)
	return nil
}

// TODO: Use as a handler for Succeeded URL callback
func VerifyPayment(installmentPlanNumber string, storedTransactionValue float64) (err error) {
	ctx := context.TODO()

	resp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanVerifyPayment(
		ctx,
		splitit.VerifyPaymentRequest{
			InstallmentPlanNumber: installmentPlanNumber,
		},
	)
	if err != nil {
		return fmt.Errorf("InstallmentPlanVerifyPayment call failed: %w", err)
	}
	if !resp.IsPaid {
		return errors.New("transaction wasn't payed")
	}

	if resp.OriginalAmountPaid == storedTransactionValue {
		// Transaction was successfull
		return nil
	}

	// Transaction amount was tampered with. Try to refund.
	_, _, err = apiClient.InstallmentPlanApi.InstallmentPlanCancel(
		ctx,
		splitit.CancelInstallmentPlanRequest{
			InstallmentPlanNumber:  installmentPlanNumber,
			RefundUnderCancelation: splitit.REFUNDUNDERCANCELATION_ONLY_IF_A_FULL_REFUND_IS_POSSIBLE,
		},
	)
	if err != nil {
		return fmt.Errorf(
			"transaction value was tampered with, but the cancellation refund failed: %w",
			err,
		)
	}
	return errors.New("transaction value was tampered with, payment was refunded")
}
