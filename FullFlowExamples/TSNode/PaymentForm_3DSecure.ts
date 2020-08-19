import * as splititApi from 'splitit-sdk-nodejs'
import { VerifyPaymentResponse } from 'splitit-sdk-nodejs'

splititApi.Configuration.sandbox.addApiKey(Credentials.apiKey)

/// <summary>
/// Scenario where 3D Secure payment is enabled
/// </summary>
class Payment3DSecure {
  planApi: splititApi.InstallmentPlanApi
  readonly MERCHANT_AMOUNT = 600

  // Authenticate with the api
  async login(userName: string, password: string) {
    const loginApi = new splititApi.LoginApi(splititApi.Configuration.sandbox)

    const { body } = await loginApi.loginPost({ userName, password })

    this.planApi = new splititApi.InstallmentPlanApi(splititApi.Configuration.sandbox, body.sessionId)
  }

  // Initiates the plan
  async initiateInstallmentPlan() {
    const initRequest: splititApi.InitiateInstallmentPlanRequest = {
      planData: {
        amount: { value: 600, currencyCode: 'USD' },
        numberOfInstallments: 3,
        refOrderNumber: 'abc123',
        autoCapture: true,
        attempt3DSecure: true,
      },
      paymentWizardData: {
        isOpenedInIframe: true,
        requestedNumberOfInstallments: '1,2,3,4,5,6',
      },
      // After user successfully interacts with splitit.com they would be
      // redirected to provided Succeeded URL with InstallmentPlanNumber as
      // a parameter in GET request. It is required to continue the flow.
      redirectUrls: {
        canceled: 'http://localhost/Canceled',
        failed: 'http://localhost/Failed',
        succeeded: 'http://localhost/Succeeded',
      },
      billingAddress: {
        addressLine: "260 Madison Avenue.",
    		city: "New York",
    		state: "NY",
    		country: "USA",
    		zip: "10016"
      }, // TODO: set actual billing address data to pre-fill the from (optional)
      consumerData: {
        fullName: "John Smith",
    		email: "JohnS@splitit.com",
    		phoneNumber: "1-415-775-4848",
        cultureName: "en-us",
        isDataRestricted: false,
        isLocked: false,
      }, // TODO: set actual consumer data to pre-fill the from (optional)
    }
    // initResponse contains urls to which you should redirect your customers (eg. checkoutUrl, termsConditionsUrl, privacyPolicyUrl, learnMoreUrl)
    // after the shopper authorized and completed the payment you need to redirect him to our page
    const { body: initResponse } = await this.planApi.installmentPlanInitiate(initRequest)
    // Use the T&C, PrivacyPolicy and the LearnMore urls
    // Save the Installment plan number for future use during the creation of a new plan

    if (initResponse.responseHeader.succeeded) {
      // TODO: take the initResponse.CheckoutUrl and redirect your shopper to it
    } else {
      // TODO: show the return error from initResponse.ResponseHeader.Errors
    }
  }

  // Checks for potential fraud attempts
  //This function MUST be called after payment is processed on Splitit's end, before merchant closes the order on his end
  async verifyPayment(installmentPlanNumber: string) {
    const { body: verifyResponse } = await this.planApi.installmentPlanVerifyPayment({ installmentPlanNumber })

    // Verifies amount payed
    // TODO: please fill the value {MERCHANT_AMOUNT} from your session
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
