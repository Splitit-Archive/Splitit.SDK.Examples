import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def start_installments(ipn):
    resp = api_client.InstallmentPlanApi.installment_plan_start_installments(
        splitit.StartInstallmentsRequest(
            installment_plan_number=ipn,
        )
    )
    return resp
