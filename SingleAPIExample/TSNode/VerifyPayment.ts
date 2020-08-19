import { InstallmentPlanApi } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function verifyPayment(installmentPlanNumber: string) {
  const { body: verifyResponse } = await planApi.installmentPlanVerifyPayment({ installmentPlanNumber })
}
