import { InstallmentPlanApi } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function approve(installmentPlanNumber: string) {
  const { body: approveResponse } = await planApi.installmentPlanApprove({
    installmentPlanNumber,
    areTermsAndConditionsApproved: true,
  })
}
