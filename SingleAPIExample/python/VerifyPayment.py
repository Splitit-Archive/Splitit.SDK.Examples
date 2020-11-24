import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def verify_payment(ipn):
    resp = api_client.InstallmentPlanApi.installment_plan_verify_payment(
        splitit.VerifyPaymentRequest(
            installment_plan_number=ipn,
        )
    )
    return resp
