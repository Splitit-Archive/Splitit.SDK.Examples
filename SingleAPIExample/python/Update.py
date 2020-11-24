import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def update_installment_plan(ipn):
    resp = api_client.InstallmentPlanApi.installment_plan_update(
        splitit.UpdateInstallmentPlanRequest(
            installment_plan_number=ipn,
            plan_data=splitit.PlanData(
                ref_order_number="abc123",
                extended_params={
                    "key1": "value1",
                    "key2": "value2",
                }
            )
        )
    )
    return resp
