# Examples

These are the examples of typical usages of the Splitit SDK. Each `PaymentForm_*` file is a self-contained script that defines all of the necessary functions to perform a payment flow.

Pay special attention to `TODO` comments, they are pointing out the key places where you need to customize the code to work with your codebase.

Basic flows differ only in installment plan parameters:
* [PaymentForm_BasicFlow.go](PaymentForm_BasicFlow.go) - simplest example
* [PaymentForm_3D.go](PaymentForm_3D.go) - requests the 3D Secure authentication
* [PaymentForm_Iframe.go](PaymentForm_Iframe.go) - allows the splitit checkout form to be presented in the Iframe
* [PaymentForm_Deposit_FutureChargeDate.go](PaymentForm_Deposit_FutureChargeDate.go) - customizes the first payment date and the deposit amount

Advanced flows allow for more complex interaction with splitit and define additional functions:
* [PaymentForm_PendingShipment.go](PaymentForm_PendingShipment.go) - allows the merchant to start the installment plan at some time after the checkout (for example after the merchant has shipped the order)
* [PaymentForm_PayWithCCToken.go](PaymentForm_PayWithCCToken.go) - allows reusing the Credit Card data saved from the previous installment by the splitit.

Calls to `InstallmentPlanVerifyPayment` and `InstallmentPlanCreate` make sense only if executed on the merchant's server.
