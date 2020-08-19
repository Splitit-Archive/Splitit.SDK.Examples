# Examples

These are the examples of typical usages of the Splitit SDK. Each `PaymentForm_*` file is a self-contained script that defines all of the necessary functions to perform a payment flow.

In production, the job of the `main` function would be done by HTTP request handlers and the database of your server.

Pay special attention to `TODO` comments, they are pointing out the key places where you need to customize the code to work with your codebase.

Basic flows differ only in installment plan parameters:
* [PaymentForm_BasicFlow](PaymentForm_BasicFlow.ts) - simplest example
* [PaymentForm_3DSecure](PaymentForm_3DSecure.ts) - requests the 3D Secure authentication
* [PaymentForm_IFrame](PaymentForm_IFrame.ts) - allows the splitit checkout form to be presented in the Iframe
* [PaymentForm_DepositFutureChargeData](PaymentForm_DepositFutureChargeData.ts) - customizes the first payment date and the deposit amount

Advanced flows allow for more complex interaction with splitit and define additional functions:
* [PaymentForm_PendingShipment](PaymentForm_PendingShipment.ts) - allows the merchant to start the installment plan at some time after the checkout (for example after the merchant has shipped the order)
* [PaymentForm_PayWithCCToken](PaymentForm_PayWithCCToken.ts) - allows reusing the Credit Card data saved from the previous installment by the splitit.

Calls to `VerifyPayment` and `InstallmentPlanCreate` make sense only if executed on the merchant's server.
