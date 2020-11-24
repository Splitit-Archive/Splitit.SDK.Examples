import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def refund_installment_plan(ipn):
    resp = api_client.InstallmentPlanApi.installment_plan_refund(
        splitit.RefundPlanRequest(
            installment_plan_number=ipn,
            amount=splitit.MoneyWithCurrencyCode(200, "USD"),
            refund_strategy=splitit.RefundStrategy.FUTUREINSTALLMENTSFIRST,
        )
    )
    return resp
