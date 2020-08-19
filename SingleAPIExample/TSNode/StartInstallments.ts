import { InstallmentPlanApi } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function startInstallments(installmentPlanNumber: string) {
  const { body: startInstallmentsResponse } = await planApi.installmentPlanStartInstallments({ installmentPlanNumber })
}
