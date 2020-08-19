package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func Refund(ipn string) {
	ctx := context.TODO()

	refundResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanRefund(
		ctx,
		splitit.RefundPlanRequest{
			InstallmentPlanNumber: ipn,
			Amount:                &splitit.MoneyWithCurrencyCode{200, "USD"},
			RefundStrategy:        splitit.REFUNDSTRATEGY_FUTURE_INSTALLMENTS_FIRST,
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanRefund call failed: %s", err)
		return
	}
	fmt.Printf("Plan refunded, Installment Plan Number: %s\n", refundResp.InstallmentPlan.InstallmentPlanNumber)
}
