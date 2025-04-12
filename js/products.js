const buttonIds = Array.from(document.querySelectorAll('.spec-btn')).map(btn => btn.id);    

document.addEventListener("DOMContentLoaded", function () {
    const Buttons = document.querySelectorAll(".spec-btn");
    const qtyInput = document.querySelector('.product-qty');
    const minusBtn = document.querySelector('.qty-count--minus');
    const addBtn = document.querySelector('.qty-count--add');
    const min = parseInt(qtyInput.min);
    const max = parseInt(qtyInput.max);

    function updateButtons() {
        const value = parseInt(qtyInput.value);
        minusBtn.disabled = value <= min;
        addBtn.disabled = value >= max;
    }

    minusBtn.addEventListener('click', () => {
        let current = parseInt(qtyInput.value);
        if (current > min) {
            qtyInput.value = current - 1;
            updateButtons();
        }
    });

    addBtn.addEventListener('click', () => {
        let current = parseInt(qtyInput.value);
        if (current < max) {
            qtyInput.value = current + 1;
            updateButtons();
        }
    });

    qtyInput.addEventListener('input', () => {
        let val = parseInt(qtyInput.value);
        if (isNaN(val) || val < min) {
            qtyInput.value = min;
        } else if (val > max) {
            qtyInput.value = max;
        }
        updateButtons();
    });

    updateButtons(); // initialize button states

    Buttons.forEach(button => {
        button.addEventListener("click", () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const price = button.dataset.price;
            const descr = button.dataset.descr;
            const photo = button.dataset.photo;
            const product = button.dataset.product;

            document.getElementById("package").src = "/images/product/" + photo;
            document.querySelector(".text h1").innerText = product;
            document.querySelector(".text h2").innerText = name;
            document.querySelector(".text p:nth-of-type(1)").innerHTML = `<b>Price:</b> RM ${price}`;
            document.querySelector(".text p:nth-of-type(2)").innerText = `Description: ${descr}`;
            buttonColor(id);
            showCart();
        });
    });
});

function buttonColor(clickedId) {
    buttonIds.forEach(buttonid => {
        const button = document.getElementById(buttonid);
        button.style.backgroundColor = "white";
        button.style.color = "black";

        if (button.id === clickedId) {
            button.style.backgroundColor = "black";
            button.style.color = "white";
        }

        button.onmouseover = function () {
            if (button.id === clickedId) {
                button.style.backgroundColor = "black";
            } else {
                button.style.backgroundColor = "lightgrey";
            }
        };

        button.onmouseout = function () {
            if (button.id === clickedId) {
                button.style.backgroundColor = "black";
                button.style.color = "white";
            } else {
                button.style.backgroundColor = "white";
                button.style.color = "black";
            }
        };
    });
}

function showCart() {
    const textbox = document.getElementById('textbox');
    const addToCartButton = document.getElementById('addToCart');
    const descriptionBox = document.getElementById('descriptionBox');

    textbox.classList.add('translated');
    addToCartButton.classList.add('translated');
    descriptionBox.classList.add('translated');
}

var QtyInput = (function () {
    var $qtyInputs = $(".qty-input");

    if (!$qtyInputs.length) {
        return;
    }

    var $inputs = $qtyInputs.find(".product-qty");
    var $countBtn = $qtyInputs.find(".qty-count");
    var qtyMin = parseInt($inputs.attr("min"));
    var qtyMax = parseInt($inputs.attr("max"));

    $inputs.change(function () {
        var $this = $(this);
        var $minusBtn = $this.siblings(".qty-count--minus");
        var $addBtn = $this.siblings(".qty-count--add");
        var qty = parseInt($this.val());

        if (isNaN(qty) || qty <= qtyMin) {
            $this.val(qtyMin);
            $minusBtn.attr("disabled", true);
        } else {
            $minusBtn.attr("disabled", false);
            
            if(qty >= qtyMax){
                $this.val(qtyMax);
                $addBtn.attr('disabled', true);
            } else {
                $this.val(qty);
                $addBtn.attr('disabled', false);
            }
        }
    });

    $countBtn.click(function () {
        var operator = this.dataset.action;
        var $this = $(this);
        var $input = $this.siblings(".product-qty");
        var qty = parseInt($input.val());

        if (operator == "add") {
            qty += 1;
            if (qty >= qtyMin + 1) {
                $this.siblings(".qty-count--minus").attr("disabled", false);
            }

            if (qty >= qtyMax) {
                $this.attr("disabled", true);
            }
        } else {
            qty = qty <= qtyMin ? qtyMin : (qty -= 1);
            
            if (qty == qtyMin) {
                $this.attr("disabled", true);
            }

            if (qty < qtyMax) {
                $this.siblings(".qty-count--add").attr("disabled", false);
            }
        }

        $input.val(qty);
    });
})();