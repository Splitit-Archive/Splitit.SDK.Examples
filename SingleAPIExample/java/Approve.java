import com.splitit.*;
import com.splitit.sdk.model.*;
import java.math.BigDecimal;


public class Approve {
    private String apiKey, username, password;
    public Approve(String username, String password, String apiKey){
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

        var result = apiClient.getInstallmentPlanApi().installmentPlanApprove(
            new ApproveInstallmentPlanRequest()
            .installmentPlanNumber(ipn)
        );
        System.out.println(result);
    }
}
