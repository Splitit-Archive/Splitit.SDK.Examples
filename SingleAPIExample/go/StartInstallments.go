package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func StartInstallments(ipn string) {
	ctx := context.TODO()

	startInstResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanStartInstallments(
		ctx,
		splitit.StartInstallmentsRequest{
			InstallmentPlanNumber: ipn,
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanStartInstallments call failed: %s\n", err)
		return
	}
	fmt.Printf("Plan started, Installment Plan Number: %s\n", startInstResp.InstallmentPlan.InstallmentPlanNumber)
}
