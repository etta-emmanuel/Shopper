<script setup>
    defineProps({
        product: {
            type: Object,
            required: true,
        },
    });

    const currency = (value) =>
        new Intl.NumberFormat('en-US', {
            currency: 'USD',
            style: 'currency',
        }).format(Number(value || 0));
</script>


<template>
    <article class="group overflow-hidden rounded-4xl border border-white/70 bg-white/90 shadow-[0_24px_70px_rgba(15,23,42,0.08)] backdrop-blur transition hover:-translate-y-1">
        <div class="relative aspect-[4/4.4] overflow-hidden bg-slate-100">
            <img
                v-if="product.src"
                :src="product.src"
                :alt="product.name"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
            />
            <div v-else class="flex h-full items-center justify-center bg-[linear-gradient(135deg,#fed7aa,#fdba74,#fb923c)] text-sm font-semibold uppercase tracking-[0.28em] text-slate-950">
                Shopper
            </div>

            <span class="absolute left-4 top-4 rounded-full bg-slate-950 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-white">
                Shop
            </span>
        </div>

        <div class="space-y-4 p-5">
            <div class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Product</p>
                <h3 class="text-xl font-bold tracking-[-0.03em] text-slate-950">{{ product.name }}</h3>
                <p class="text-sm leading-6 text-slate-600">
                    Clean product presentation for catalog browsing, admin previews, and future detail pages.
                </p>
            </div>

            <div class="flex items-end justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-2xl font-black tracking-[-0.03em] text-slate-950">{{ currency(product.price) }}</p>
                    <p class="text-sm text-slate-500">Ready for the shop grid.</p>
                </div>

                <div class="rounded-full bg-amber-100 px-3 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-amber-900">
                    #{{ product.id }}
                </div>
            </div>
        </div>
    </article>
</template>
