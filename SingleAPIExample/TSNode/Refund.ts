import { InstallmentPlanApi, RefundStrategy } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function refund(installmentPlanNumber: string) {
  const { body: refundResponse } = await planApi.installmentPlanRefund({
    installmentPlanNumber,
    amount: { value: 600, currencyCode: 'USD' },
    refundStrategy: RefundStrategy.FutureInstallmentsLast,
  })
}
