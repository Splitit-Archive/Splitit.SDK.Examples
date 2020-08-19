package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func Initiate() {
	ctx := context.TODO()

	initPaymentResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanInitiate(
		ctx,
		splitit.InitiateInstallmentPlanRequest{
			PlanData: &splitit.PlanData{
				AutoCapture:          true,
				Amount:               &splitit.MoneyWithCurrencyCode{600, "USD"},
				NumberOfInstallments: 3,
				RefOrderNumber:       "abc123",
			},
			PaymentWizardData: &splitit.PaymentWizardData{
				RequestedNumberOfInstallments: "2,3,4,5,6",
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
			RedirectUrls: &splitit.RedirectUrls{
				Succeeded: "http://localhost/Succeeded",
				Canceled:  "http://localhost/Canceled",
				Failed:    "http://localhost/Failed",
			},
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanInitiate call failed: %s\n", err)
		return
	}
	fmt.Printf("Plan initiated, checkout URL: %s\n\n", initPaymentResp.CheckoutUrl)
}
