import * as splititApi from 'splitit-sdk-nodejs'
import { VerifyPaymentResponse } from 'splitit-sdk-nodejs'

splititApi.Configuration.sandbox.addApiKey(Credentials.apiKey)

/// <summary>
/// Scenario where a cc token from the previous plan is used to create a new one
/// </summary>
class PayWithCCToken {
  planApi: splititApi.InstallmentPlanApi
  readonly MERCHANT_AMOUNT = 600

  // Authenticate with the api
  async login(userName: string, password: string) {
    const loginApi = new splititApi.LoginApi(splititApi.Configuration.sandbox)

    const { body } = await loginApi.loginPost({ userName, password })

    this.planApi = new splititApi.InstallmentPlanApi(splititApi.Configuration.sandbox, body.sessionId)
  }

  // Retrieves the credit card token from previous splitit installment plan of a returning shopper
  // TODO get the oldInstallmentPlanNumber from your DB
  async getCCToken(oldInstallmentPlanNumber: string) {
    const { body: getResponse } = await this.planApi.installmentPlanGet({
      // @ts-ignore
      queryCriteria: {
        installmentPlanNumber: oldInstallmentPlanNumber,
      },
    })

    return getResponse.plansList[0].activeCard.token
  }

  // Set a new installment plan for the returning shopper
  async initiateInstallmentPlan() {
    const initRequest: splititApi.InitiateInstallmentPlanRequest = {
      planData: {
        amount: { value: 600, currencyCode: 'USD' },
        numberOfInstallments: 3,
        refOrderNumber: 'abc123',
        autoCapture: true,
      },
      billingAddress: {
        addressLine: '260 Madison Avenue.',
        city: 'New York',
        state: 'NY',
        country: 'USA',
        zip: '10016',
      }, // TODO: set actual billing address data to pre-fill the from (optional)
      consumerData: {
        fullName: 'John Smith',
        email: 'JohnS@splitit.com',
        phoneNumber: '1-415-775-4848',
        cultureName: 'en-us',
        isDataRestricted: false,
        isLocked: false,
      }, // TODO: set actual consumer data to pre-fill the from (optional)
    }

    const { body: initResponse } = await this.planApi.installmentPlanInitiate(initRequest)
    // Use the T&C, PrivacyPolicy and the LearnMore urls
    // Save the Installment plan number for future use during the creation of a new plan
    const newPlanNumber = initResponse.installmentPlan.installmentPlanNumber

    return newPlanNumber
  }

  // Make a payment for the new plan with an existing card token
  // TODO: Use as a handler for the subsequent Checkout requests
  async payWithCCToken(newPlanNumber: string, ccToken: string) {
    // Create another plan using the card token from the previous
    await this.planApi.installmentPlanCreate({
      paymentToken: {
        token: ccToken,
        type: 'card',
      },
      installmentPlanNumber: newPlanNumber,
      planApprovalEvidence: { areTermsAndConditionsApproved: true },
    })
  }

  async verifyPayment(installmentPlanNumber: string) {
    // Checks for potential fraud attempts
    //This function MUST be called after payment is processed on Splitit's end, before merchant closes the order on his end
    const { body: verifyResponse } = await this.planApi.installmentPlanVerifyPayment({ installmentPlanNumber })

    // Verifies amount payed
    // For Merchant: please fill the value {MERCHANT_AMOUNT} from your session
    const paymentVerified =
      verifyResponse.responseHeader?.succeeded &&
      verifyResponse.isPaid &&
      verifyResponse.originalAmountPaid === this.MERCHANT_AMOUNT

    if (paymentVerified) {
      // TODO: Success - close order in your system
    } else {
      // TODO: call the InstallmentPlanCancel function with the installment plan number
    }
  }
}
