import com.splitit.*;
import com.splitit.sdk.model.*;
import java.math.BigDecimal;


public class Create {
    private String apiKey, username, password;
    public Create(String username, String password, String apiKey){
        this.username = username;
        this.password = password;
        this.apiKey = apiKey;
    }

    public void example() throws ApiException{
        ApiClient apiClient = new ApiClient()
            .sandbox(true)
            .username(username)
            .password(password)
            .apiKey(apiKey);


        var result = apiClient.getInstallmentPlanApi().installmentPlanCreate(
            new CreateInstallmentPlanRequest()
            .planData(
                new PlanData()
                .autoCapture(true)
                .amount(
                    new MoneyWithCurrencyCode()
                    .value(new BigDecimal(600))
                    .currencyCode("USD")
                )
                .numberOfInstallments(3)
                .refOrderNumber("abc123")
            )
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
            .creditCardDetails(
                new CardData()
                .cardHolderFullName("John Smith")
                .cardNumber("4111111111111111")
                .cardExpYear("2022")
                .cardExpMonth("8")
                .cardCvv("123")
            )
            .planApprovalEvidence(
                new PlanApprovalEvidence()
                .areTermsAndConditionsApproved(true)
            )
        );
        System.out.println(result);
    }
}
