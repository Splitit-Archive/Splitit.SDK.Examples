import splitit
from splitit.rest import ApiException

username, password, api_key = (
    'username',
    'password',
    'api_key'
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def get_cc_token(old_installment_plan_no):
    """For a returning shopper, use an existing plan that is related to that shopper"""
    resp = api_client.InstallmentPlanApi.installment_plan_get(
        splitit.GetInstallmentsPlanSearchCriteriaRequest(
            splitit.InstallmentPlanQueryCriteria(
                installment_plan_number=old_installment_plan_no,
            )
        )
    )
    return resp.plans_list[0].active_card.token


def initiate_new_plan():
    """Set a new installment plan for the returning shopper"""
    # TODO: Fill-in the data
    resp = api_client.InstallmentPlanApi.installment_plan_initiate(
        splitit.InitiateInstallmentPlanRequest(
            plan_data=splitit.PlanData(
                auto_capture=True,
                amount=splitit.MoneyWithCurrencyCode(300, "USD"),
                number_of_installments=3,
                ref_order_number="abc123",
            ),
            payment_wizard_data=splitit.PaymentWizardData(
                requested_number_of_installments="2,3,4,5,6",
            ),
            billing_address=splitit.AddressData2(
                address_line="260 Madison Avenue.",
                city="New York",
                state="NY",
                country="USA",
                zip="10016",
            ),
            consumer_data=splitit.ConsumerData(
                full_name="John Smith",
                email="JohnS@splitit.com",
                phone_number="1-415-775-4848",
                culture_name="en-us",
            ),

        )
    )
    return resp


def pay_with_token(new_plan_number, cc_token):
    """Create the installment plan using Credit Card Token"""
    # TODO: Customize the data
    resp = api_client.InstallmentPlanApi.installment_plan_create(
        splitit.CreateInstallmentPlanRequest(
            installment_plan_number=new_plan_number,
            plan_data=splitit.PlanData(
                amount=splitit.MoneyWithCurrencyCode(300, "USD"),
            ),
            payment_token=splitit.PaymentToken(
                token=cc_token,
                type="SplititStoredCard",
            )
        )
    )
    print("Successfully payed for the plan")
    return resp
