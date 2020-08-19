package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

func Get(ipn string) {
	ctx := context.TODO()

	getResp, _, err := apiClient.InstallmentPlanApi.InstallmentPlanGet(
		ctx,
		splitit.GetInstallmentsPlanSearchCriteriaRequest{
			QueryCriteria: &splitit.InstallmentPlanQueryCriteria{
				InstallmentPlanNumber: ipn,
			},
		},
	)
	if err != nil {
		fmt.Printf("InstallmentPlanGet call failed: %s\n", err)
		return
	}
	fmt.Printf("Got %d plans as a search result\n", len(getResp.PlansList))
}
