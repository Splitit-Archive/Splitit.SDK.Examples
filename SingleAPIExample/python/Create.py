import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def create_installment_plan():
    resp = api_client.InstallmentPlanApi.installment_plan_create(
        splitit.CreateInstallmentPlanRequest(
            plan_data=splitit.PlanData(
                auto_capture=True,
                amount=splitit.MoneyWithCurrencyCode(600, "USD"),
                number_of_installments=3,
                ref_order_number="abc123",
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
            credit_card_details=splitit.CardData(
                card_holder_full_name="John Smith",
                card_number="4111111111111111",
                card_exp_year="2022",
                card_exp_month="8",
                card_cvv="123",
            ),
            plan_approval_evidence=splitit.PlanApprovalEvidence(
                are_terms_and_conditions_approved=True,
            ),
        )
    )
    return resp
