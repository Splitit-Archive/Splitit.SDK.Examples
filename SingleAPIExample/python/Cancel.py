import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def cancel_installment_plan(ipn):
    resp = api_client.InstallmentPlanApi.installment_plan_cancel(
        splitit.CancelInstallmentPlanRequest(
            installment_plan_number=ipn,
            refund_under_cancelation=splitit.RefundUnderCancelation.ONLYIFAFULLREFUNDISPOSSIBLE,
        )
    )
    return resp
