package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func Approve(ipn string) {
	ctx := context.TODO()

	approvePaymentResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanApprove(
		ctx,
		splitit.ApproveInstallmentPlanRequest{
			InstallmentPlanNumber: ipn,
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanApprove call failed: %s\n", err)
		return
	}
	fmt.Printf("Plan approved, Installment Plan Number: %s\n", approvePaymentResp.InstallmentPlan.InstallmentPlanNumber)
}
