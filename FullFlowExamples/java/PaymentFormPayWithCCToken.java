import com.splitit.*;
import com.splitit.sdk.model.*;
import java.math.BigDecimal;
import java.math.RoundingMode;
import org.threeten.bp.OffsetDateTime;


public class PaymentFormPayWithCCToken {
    private ApiClient apiClient;
    public PaymentFormPayWithCCToken(String username, String password, String apiKey){
        this.apiClient = new ApiClient()
            .sandbox(true)
            .username(username)
            .password(password)
            .apiKey(apiKey);
    }

    // For a returning shopper, use an existing plan that is related to that shopper
    public String getCCToken(String oldInstallmentPlanNumber) throws ApiException{
        var resp = apiClient.getInstallmentPlanApi().installmentPlanGet(
            new GetInstallmentsPlanSearchCriteriaRequest()
            .queryCriteria(
                new InstallmentPlanQueryCriteria()
                .installmentPlanNumber(oldInstallmentPlanNumber)
            )
        );
        return resp.getPlansList().get(0).getActiveCard().getToken();
    }


    // Set a new installment plan for the returning shopper
    public InitiateInstallmentsPlanResponse initiateNewPlan() throws ApiException{
        // TODO: Fill-in the data
        InitiateInstallmentsPlanResponse resp = apiClient.getInstallmentPlanApi().installmentPlanInitiate(
            new InitiateInstallmentPlanRequest()
            .planData(
                new PlanData()
                .autoCapture(true)
                .amount(
                    new MoneyWithCurrencyCode()
                    .value(new BigDecimal("300"))
                    .currencyCode("USD")
                )
                .numberOfInstallments(3)
                .refOrderNumber("abc123")
            )
            .paymentWizardData(
                new PaymentWizardData()
                .requestedNumberOfInstallments("2,3,4,5,6")
            )
            // Optional data to pre-fill the form
            .billingAddress(
                new AddressData()
                .addressLine("260 Madison Avenue.")
                .city("New York")
                .state("NY")
                .country("USA")
                .zip("10016")
            )
            .consumerData(
                new ConsumerData()
                .fullName("John Smith")
                .email("JohnS@splitit.com")
                .phoneNumber("1-415-775-4848")
                .cultureName("en-us")
            )
        );
        return resp;
    }

    // Create the installment plan using Credit Card Token
    public void payWithToken(String installmentPlanNumber, String ccToken) throws ApiException{
        var resp = apiClient.getInstallmentPlanApi().installmentPlanCreate(
            new CreateInstallmentPlanRequest()
            .installmentPlanNumber(installmentPlanNumber)
            .planData(
                new PlanData()
                .amount(
                    new MoneyWithCurrencyCode()
                    .value(new BigDecimal("300"))
                    .currencyCode("USD")
                )
            )
            .paymentToken(
                new PaymentToken()
                .token(ccToken)
                .type("SplititStoredCard")
            )
        );

        System.out.println("Successfully payed for the plan");
    }
}
