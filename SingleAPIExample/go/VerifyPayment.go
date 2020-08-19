package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func VerifyPayment(ipn string) {
	ctx := context.TODO()

	verifyResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanVerifyPayment(
		ctx,
		splitit.VerifyPaymentRequest{
			InstallmentPlanNumber: ipn,
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanVerifyPayment call failed: %s\n", err)
		return
	}
	if verifyResp.IsPaid {
		fmt.Printf("Plan is payed for %f\n", verifyResp.OriginalAmountPaid)
	} else {
		fmt.Printf("Plan wasn't payed\n")
	}

}
