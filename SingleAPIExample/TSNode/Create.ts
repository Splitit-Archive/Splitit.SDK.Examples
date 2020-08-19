import { InstallmentPlanApi, TestModes, PlanStrategy, PurchaseMethod } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function create(installmentPlanNumber: string) {
  const { body: createResponse } = await planApi.installmentPlanCreate({
    installmentPlanNumber,
    planData: {
      amount: { value: 600, currencyCode: 'USD' },
      numberOfInstallments: 3,
      refOrderNumber: 'abc123',
      autoCapture: true,
      purchaseMethod: PurchaseMethod.ECommerce,
      firstChargeDate: new Date(),
      firstInstallmentAmount: { value: 200, currencyCode: 'USD' },
      extendedParams: {
        AnyParamaterKey1: 'AnyParameterVal1',
        AnyParameterKey2: 'AnyParameterVal2',
      },
    },
    planApprovalEvidence: { areTermsAndConditionsApproved: true },
    redirectUrls: {
      canceled: 'http://localhost/Canceled',
      failed: 'http://localhost/Failed',
      succeeded: 'http://localhost/Succeeded',
    },
    billingAddress: {
      addressLine: '260 Madison Avenue.',
      city: 'New York',
      state: 'NY',
      country: 'USA',
      zip: '10016',
    },
    consumerData: {
      fullName: 'John Smith',
      email: 'JohnS@splitit.com',
      phoneNumber: '1-415-775-4848',
      cultureName: 'en-us',
      isLocked: false,
      isDataRestricted: false,
    },
    creditCardDetails: {
      cardNumber: '411111111111111',
      cardCvv: '111',
      cardHolderFullName: 'John Smith',
      cardExpMonth: '12',
      cardExpYear: '2022',
    },
  })
}
