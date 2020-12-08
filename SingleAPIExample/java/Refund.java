import com.splitit.*;
import com.splitit.sdk.model.*;
import java.math.BigDecimal;


public class Refund {
    private String apiKey, username, password;
    public Refund(String username, String password, String apiKey){
        this.username = username;
        this.password = password;
        this.apiKey = apiKey;
    }

    public void example(String ipn) throws ApiException{
        ApiClient apiClient = new ApiClient()
            .sandbox(true)
            .username(username)
            .password(password)
            .apiKey(apiKey);


        var result = apiClient.getInstallmentPlanApi().installmentPlanRefund(
            new RefundPlanRequest()
            .installmentPlanNumber(ipn)
            .amount(
                new MoneyWithCurrencyCode()
                .value(new BigDecimal(200))
                .currencyCode("USD")
            )
            .refundStrategy(RefundStrategy.FUTUREINSTALLMENTSFIRST)

        );
        System.out.println(result);
    }
}
