import splitit
from splitit.rest import ApiException

username, password, api_key = (
    'username',
    'password',
    'api_key'
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def initiate_installment_plan(transactionValue):
    """Use as a handler for Checkout request"""
    # TODO: Customize the data
    resp = api_client.InstallmentPlanApi.installment_plan_initiate(
        splitit.InitiateInstallmentPlanRequest(
            plan_data=splitit.PlanData(
                auto_capture=True,
                amount=splitit.MoneyWithCurrencyCode(transactionValue, "USD"),
                number_of_installments=3,
                ref_order_number="abc123",
            ),
            payment_wizard_data=splitit.PaymentWizardData(
                requested_number_of_installments="2,3,4,5,6",
            ),
            # Optional data to pre-fill the form
            billing_address=splitit.AddressData2(
                address_line="260 Madison Avenue.",
                city="New York",
                state="NY",
                country="USA",
                zip="10016",
            ),
            # Optional data to pre-fill the form
            consumer_data=splitit.ConsumerData(
                full_name="John Smith",
                email="JohnS@splitit.com",
                phone_number="1-415-775-4848",
                culture_name="en-us",
            ),
            # After user successfully interacts with splitit.com they would be
            # redirected to provided Succeeded URL with InstallmentPlanNumber as
            # a parameter in GET request. It is required to continue the flow.
            redirect_urls=splitit.RedirectUrls(
                succeeded="http://localhost/Succeeded",
                canceled="http://localhost/Canceled",
                failed="http://localhost/Failed",
            ),
        )
    )

    # TODO: Redirect customer to initPaymentResp.CheckoutUrl
    print("Go to {}\n".format(resp.checkout_url))
    return resp


def verify_payment(installmentPlanNumber, storedTransactionValue):
    """Use as a handler for Succeeded URL callback"""
    resp = api_client.InstallmentPlanApi.installment_plan_verify_payment(
        splitit.VerifyPaymentRequest(
            installment_plan_number=installmentPlanNumber,
        )
    )
    assert resp.is_paid, "Transaction wasn't payed"
    try:
        assert resp.original_amount_paid == storedTransactionValue, "transaction value was tampered with"
    except AssertionError:
        try:
            resp = api_client.InstallmentPlanApi.installment_plan_cancel(
                splitit.CancelInstallmentPlanRequest(
                    installment_plan_number=installmentPlanNumber,
                    refund_under_cancelation=splitit.RefundUnderCancelation.ONLYIFAFULLREFUNDISPOSSIBLE,
                )
            )
        except ApiException:
            print("transaction value was tampered with, but the cancellation refund failed:")
            raise
        else:
            print("transaction value was tampered with, payment was refunded")
    else:
        print("Transaction for {} successfully verified".format(resp.original_amount_paid))
