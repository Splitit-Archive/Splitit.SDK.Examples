import com.splitit.*;
import com.splitit.sdk.model.*;
import java.math.BigDecimal;
import java.math.RoundingMode;


public class PaymentFormPendingShipment {
    private ApiClient apiClient;
    public PaymentFormPendingShipment(String username, String password, String apiKey){
        this.apiClient = new ApiClient()
            .sandbox(true)
            .username(username)
            .password(password)
            .apiKey(apiKey);
    }

    // Use as a handler for Checkout request
    public void initiateInstallmentPlan(BigDecimal transactionValue) throws ApiException{

        // TODO: Customize the data
        var resp = apiClient.getInstallmentPlanApi().installmentPlanInitiate(
            new InitiateInstallmentPlanRequest()
            .planData(
                new PlanData()
                .autoCapture(false)
                .amount(
                    new MoneyWithCurrencyCode()
                    .value(transactionValue)
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
            // After user successfully interacts with splitit.com they would be
            // redirected to provided Succeeded URL with InstallmentPlanNumber as
            // a parameter in GET request. It is required to continue the flow.
            .redirectUrls(
                new RedirectUrls()
                .succeeded("http://localhost/Succeeded")
                .canceled("http://localhost/Canceled")
                .failed("http://localhost/Failed")
            )
        );
        // TODO: Redirect customer to initPaymentResp.CheckoutUrl
        System.out.println("Go to " + resp.getCheckoutUrl());
    }

    // Use as a handler for Succeeded URL callback
    public void verifyPayment(String installmentPlanNumber, BigDecimal storedTransactionValue) throws ApiException{
        var resp = apiClient.getInstallmentPlanApi().installmentPlanVerifyPayment(
            new VerifyPaymentRequest()
            .installmentPlanNumber(installmentPlanNumber)
        );
        if (!resp.isIsPaid()){
            System.out.println("Transaction wasn't payed");
            return;
        }

        if (storedTransactionValue.setScale(3, RoundingMode.HALF_UP).compareTo(resp.getOriginalAmountPaid()) == 0){
            System.out.printf("Transaction for %.2f successfully verified\n", storedTransactionValue);
            return;
        }

        // the amounts didn't match
        apiClient.getInstallmentPlanApi().installmentPlanCancel(
            new CancelInstallmentPlanRequest()
            .installmentPlanNumber(installmentPlanNumber)
            .refundUnderCancelation(
                RefundUnderCancelation.ONLYIFAFULLREFUNDISPOSSIBLE
            )
        );
        System.out.println("Transaction value was tampered with, payment was refunded");
    }

    // Starts the installments for the installmentPlanNumber
    public void startInstallments(String installmentPlanNumber) throws ApiException{
        apiClient.getInstallmentPlanApi().installmentPlanStartInstallments(
            new StartInstallmentsRequest()
            .installmentPlanNumber(installmentPlanNumber)
        );
        System.out.printf("Installments started on IPN %s\n", installmentPlanNumber);
    }
}
