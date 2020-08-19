import { InstallmentPlanApi, RefundUnderCancelation, InstallmentPlanCancelationReason } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function cancel(installmentPlanNumber: string) {
  const { body: cancelResponse } = await planApi.installmentPlanCancel({
    installmentPlanNumber,
    refundUnderCancelation: RefundUnderCancelation.NoRefunds,
    cancelationReason: InstallmentPlanCancelationReason.Other,
    isExecutedUnattended: false,
  })
}
