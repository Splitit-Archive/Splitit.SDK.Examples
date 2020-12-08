import com.splitit.*;
import com.splitit.sdk.model.*;
import java.math.BigDecimal;


public class Update {
    private String apiKey, username, password;
    public Update(String username, String password, String apiKey){
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


        var result = apiClient.getInstallmentPlanApi().installmentPlanUpdate(
            new UpdateInstallmentPlanRequest()
            .installmentPlanNumber(ipn)
            .planData(
                new PlanData()
                .refOrderNumber("abc123")
                .putExtendedParamsItem("key1", "value1")
                .putExtendedParamsItem("key2", "value2")
            )
        );
        System.out.println(result);
    }
}
