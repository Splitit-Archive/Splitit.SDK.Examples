import com.splitit.*;
import com.splitit.sdk.model.*;
import java.math.BigDecimal;


public class StartInstallments {
    private String apiKey, username, password;
    public StartInstallments(String username, String password, String apiKey){
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


        var result = apiClient.getInstallmentPlanApi().installmentPlanStartInstallments(
            new StartInstallmentsRequest()
            .installmentPlanNumber(ipn)
        );
        System.out.println(result);
    }
}
