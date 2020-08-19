import { InstallmentPlanApi } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function initiate() {
  const { body: initResponse } = await planApi.installmentPlanInitiate({
    planData: {
      amount: { value: 600, currencyCode: 'USD' },
      numberOfInstallments: 3,
      refOrderNumber: 'abc123',
      autoCapture: true,
    },
    paymentWizardData: { requestedNumberOfInstallments: '2,3,4,5,6', isOpenedInIframe: false },
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
  })
}
