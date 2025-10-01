import { loadMercadoPago } from "@mercadopago/sdk-js";
const el = document.getElementById("checkout-data");
const amount = parseFloat(el.dataset.planPrice);
const planId = el.dataset.planId;
const csrf = el.dataset.csrf;
const processUrl = el.dataset.processUrl;
const publicKey = el.dataset.publicKey;

await loadMercadoPago();
const mp = new MercadoPago(publicKey, { locale: "pt-BR" });
const bricksBuilder = mp.bricks();

async function switchToStatusScreen() {
    document.getElementById("form-checkout").style.display = "none";
    document.getElementById("status-screen-container").style.display = "block";
}

console.log("pássadno aq");
async function renderStatusScreen(paymentId) {
    await bricksBuilder.create("statusScreen", "status-screen-container", {
        initialization: {
            paymentId: paymentId,
        },
        callbacks: {
            onReady: () => {
                console.log("Status Screen carregada");
            },
            onError: (error) => {
                console.error("Erro ao renderizar Status Screen:", error);
            },
        },
    });
}

await bricksBuilder.create("payment", "form-checkout", {
    initialization: {
        amount,
        paymentMethods: {
            excludedPaymentTypes: [],
            excludedPaymentMethods: [],
        },
    },
    customization: {
        paymentMethods: {
            ticket: "all",
            bankTransfer: "all",
            creditCard: "all",
        },
    },
    callbacks: {
        onReady: () => console.log("Brick Payment pronto"),
        onSubmit: async (formData) => {
            const csrfToken = document
                .querySelector('meta[name="csrf_token"]')
                .getAttribute("content");

            const res = await fetch(processUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                credentials: "same-origin", // <== ESSENCIAL para enviar cookies de sessão!
                body: JSON.stringify({
                    ...formData,
                    plan_id: planId,
                }),
            });

            const result = await res.json();

            if (result.payment_id) {
                await switchToStatusScreen();
                await renderStatusScreen(result.payment_id);

                if (result.status === "approved") {
                    let countdown = 30;
                    const statusContainer = document.getElementById(
                        "status-screen-container",
                    );

                    const countdownEl = document.createElement("p");
                    countdownEl.className =
                        "my-6 text-lg font-semibold tracking-wide text-center";
                    statusContainer.appendChild(countdownEl);

                    const interval = setInterval(() => {
                        countdownEl.textContent = `Você será redirecionado em ${countdown} segundos...`;
                        countdown--;

                        if (countdown < 0) {
                            clearInterval(interval);
                            window.location.href = result.redirect_url;
                        }
                    }, 1000);
                }
            } else {
                alert(result.message || "Erro ao processar pagamento.");
            }
        },
        onError: (error) => console.error("Erro:", error),
    },
});
