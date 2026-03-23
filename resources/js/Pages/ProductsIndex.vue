<template>
    <div class="space-y-8">
        <section class="rounded-[2rem] border border-white/70 bg-white/85 p-8 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
            <div class="grid gap-8 xl:grid-cols-[1.1fr_0.9fr] xl:items-end">
                <div>
                    <p class="inline-flex rounded-full border border-amber-300 bg-amber-50 px-4 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-amber-800">
                        Shop
                    </p>
<!--                    <h1 class="mt-5 max-w-4xl text-5xl font-black leading-none tracking-[-0.055em] text-balance sm:text-6xl">
                        Browse a polished product grid built from reusable cards.
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-700 sm:text-lg">
                        This page is the storefront index shell. Product cards are reusable, image-aware, and ready for richer
                        catalog filters later.
                    </p>-->
                </div>

<!--                <div class="rounded-[2rem] bg-slate-950 p-6 text-white shadow-[0_24px_70px_rgba(15,23,42,0.16)]">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300">Catalog status</p>
                    <p class="mt-3 text-3xl font-black tracking-[-0.04em]">{{ products.length }}</p>
                    <p class="mt-2 text-sm leading-6 text-white/70">
                        Products are rendered from the web product controller, while non-GET product mutations belong to the API
                        resource controller.
                    </p>
                </div>-->
            </div>
        </section>

        <section v-if="featuredProduct" class="rounded-[2rem] border border-white/70 bg-white/85 p-8 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Featured product</p>
            <div class="mt-5 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
                <div class="overflow-hidden rounded-[2rem] bg-slate-100">
                    <img
                        v-if="featuredProduct.images?.[0]?.full"
                        :src="featuredProduct.images[0].full"
                        :alt="featuredProduct.images[0].alt_text || featuredProduct.name"
                        class="h-full w-full object-cover"
                    />
                    <div
                        v-else
                        class="flex min-h-[22rem] items-center justify-center bg-[linear-gradient(135deg,#fed7aa,#fdba74,#fb923c)] text-sm font-semibold uppercase tracking-[0.28em] text-slate-950"
                    >
                        Shopper
                    </div>
                </div>

                <div class="flex flex-col justify-center">
                    <h2 class="text-4xl font-black tracking-[-0.04em] text-slate-950">{{ featuredProduct.name }}</h2>
                    <p class="mt-4 text-base leading-8 text-slate-700">
                        Detail-ready product data can be rendered here without changing the card component used in the grid.
                    </p>
                    <div class="mt-6 flex items-end gap-4">
                        <p class="text-3xl font-black tracking-[-0.03em] text-slate-950">{{ currency(featuredProduct.price) }}</p>
                        <p v-if="featuredProduct.discount > 0" class="text-sm text-slate-500">
                            <span class="line-through">{{ currency(featuredProduct.base_price) }}</span>
                            <span class="ml-2 text-emerald-700">-{{ currency(featuredProduct.discount) }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="mb-5 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Product grid</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-[-0.03em] text-slate-950">Available products</h2>
                </div>
            </div>

            <div v-if="products.length" class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                <ProductCard v-for="product in products" :key="product.id" :product="product" />
            </div>

            <div
                v-else
                class="rounded-[2rem] border border-dashed border-slate-300 bg-white/70 p-10 text-center text-sm text-slate-600"
            >
                No products are available yet.
            </div>
        </section>
    </div>
</template>

<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import ProductCard from '../Components/ProductCard.vue';

defineOptions({
    layout: AppLayout,
});

defineProps({
    featuredProduct: {
        type: Object,
        default: null,
    },
    products: {
        type: Array,
        default: () => [],
    },
});

const currency = (value) =>
    new Intl.NumberFormat('en-US', {
        currency: 'USD',
        style: 'currency',
    }).format(Number(value || 0));
</script>
