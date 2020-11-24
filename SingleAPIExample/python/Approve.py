import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def approve_installment_plan(ipn):
    resp = api_client.InstallmentPlanApi.installment_plan_approve(
        splitit.ApproveInstallmentPlanRequest(
            installment_plan_number=ipn,
        )
    )
    return resp
