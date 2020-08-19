import { InstallmentPlanApi } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function get(installmentPlanNumber: string) {
  const { body: getResponse } = await planApi.installmentPlanGet({
    // @ts-ignore
    queryCriteria: {
      installmentPlanNumber,
    },
  })
}
