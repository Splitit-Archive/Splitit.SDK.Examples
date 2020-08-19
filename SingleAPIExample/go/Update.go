package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func Update(ipn string) {
	ctx := context.TODO()

	updResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanUpdate(
		ctx,
		splitit.UpdateInstallmentPlanRequest{
			InstallmentPlanNumber: ipn,
			PlanData: &splitit.PlanData{
				RefOrderNumber: "abc123",
				ExtendedParams: map[string]string{
					"key1": "value1",
					"key2": "value2",
				},
			},
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanUpdate call failed: %s\n", err)
		return
	}
	fmt.Printf("Plan updated, Installment Plan Number: %s\n", updResp.InstallmentPlan.InstallmentPlanNumber)
}
