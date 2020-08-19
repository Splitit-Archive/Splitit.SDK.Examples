package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func Create() {
	ctx := context.TODO()

	createPaymentResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanCreate(
		ctx,
		splitit.CreateInstallmentPlanRequest{
			PlanData: &splitit.PlanData{
				AutoCapture:          true,
				Amount:               &splitit.MoneyWithCurrencyCode{600, "USD"},
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
			CreditCardDetails: &splitit.CardData{
				CardHolderFullName: "John Smith",
				CardNumber:         "4111111111111111",
				CardExpYear:        "2022",
				CardExpMonth:       "8",
				CardCvv:            "123",
			},
			PlanApprovalEvidence: &splitit.PlanApprovalEvidence{
				AreTermsAndConditionsApproved: true,
			},
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanCreate call failed: %s\n", err)
		return
	}
	fmt.Printf("Plan created, Installment Plan Number: %s\n", createPaymentResp.InstallmentPlan.InstallmentPlanNumber)
}
