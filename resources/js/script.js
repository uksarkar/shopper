import axios from 'axios';
var app = new Vue({
    el: "#app",
    data: {
        showMenu: "hidden",
        allCatBorder: "border-transparent",
        previewImage: false,
        previewImageUrl: "",
        showModel: false,
        tabs: 1,
        shops: [],
        productId: null,
        details: {},
        showLoading: false,
        addPriceCount: 0,
        prices: [],
        storedPrices: [],
        productVariants: [],
        selectedVariant: null,
        variantsForEdit: []
    },
    methods: {
        toggleMenu() {
            this.showMenu === "hidden"
                ? (this.showMenu = "")
                : (this.showMenu = "hidden");
        },
        loadShops(product) {
            this.previewImage = product.image ? product.image.url : "https://via.placeholder.com/300x300.png?text=No+Image";
            this.productId = product.id;
            axios.get(`/account/getShops?product_id=${product.id}`).then(res => {
                this.shops = [{ id: 0, name: "All shops" }, ...res.data];
            });
        },
        showTooltips(e) {
            let option = e.target.nextElementSibling.style.display;
            if (option) {
                e.target.nextElementSibling.style.display = null;
            } else {
                e.target.nextElementSibling.style.display = "block";
            }
        },
        editPrice(price, variants) {
            this.details = { productId: price.product_id, priceId: price.id, amounts: price.amounts };
            this.shops = [price.shop];
            this.productId = price.product_id;
            this.showModel = true;
            this.variantsForEdit = variants;
        },
        getPrices() {
            let productId = this.$refs.theProductId.value;
            axios.get(`/getProductPrices?product_id=${productId}`).then(res => {
                let usedVariants = [];
                res.data.forEach(item => {
                    item.variants.forEach(variant => {
                        if (!usedVariants.includes(variant.variant_name)) {
                            usedVariants.push(variant.variant_name);
                        }
                    });
                });
                this.productVariants = usedVariants;
                this.storedPrices = res.data;
                this.selectedVariant = usedVariants[0];
                this.serializeShops(res.data);
            });
        },
        serializeShops(data) {
            let theVariant = this.selectedVariant;
            let newData = data.filter(v => v.variants.filter(c => c.variant_name === theVariant).length === 1);
            let result = newData.sort((a, b) => {
                let first = a.variants.filter(c => c.variant_name === theVariant)[0].price;
                let second = b.variants.filter(c => c.variant_name === theVariant)[0].price;
                return first - second;
            });
            this.prices = result;
            if (result.length === 0) {
                this.loadFailed = true;
            }
        }
    },
    mounted() {
        if (this.$refs.theProductId) {
            this.getPrices();
        }
        document.addEventListener("click", function (e) {
            let allOptions = document.querySelectorAll("div.options");
            allOptions.forEach(el => {
                el.style.display = null;
            });
            if (e.target.dataset.options === 'btn') {
                e.target.nextElementSibling.style.display = "block";
            }
        });
    }
});