package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func Cancel(ipn string) {
	ctx := context.TODO()

	cancelResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanCancel(
		ctx,
		splitit.CancelInstallmentPlanRequest{
			InstallmentPlanNumber:  ipn,
			RefundUnderCancelation: splitit.REFUNDUNDERCANCELATION_ONLY_IF_A_FULL_REFUND_IS_POSSIBLE,
			// TODO: CancelationReason should be optional, waiting for swagger.json update
			CancelationReason: splitit.INSTALLMENTPLANCANCELATIONREASON_OTHER,
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanCancel call failed: %s\n", err)
		return
	}
	fmt.Printf("Plan cancelled, Installment Plan Number: %s\n", cancelResp.InstallmentPlan.InstallmentPlanNumber)
}
