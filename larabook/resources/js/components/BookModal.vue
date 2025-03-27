<script setup>
defineProps({
    show: Boolean,
    venueObject: Object
});
</script>

<template>
    <Transition
    enter-from-class="opacity-0 scale-125"
    enter-to-class="opacity-100"
    enter-active-class="transition duration-300"
    leave-active-class="transition duration-500"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0 scale-150"
    >
        <div v-if="show" class="modal-mask" @click="$emit('close')">

            <div class="modal-container" @click.stop>
                <header>
                    <slot name="header">default header</slot>
                </header>

                <div>
                    <slot>default body</slot>
                </div>

                <footer class="footer">
                    <slot name="footer">
                        <button @click="$emit('close')"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            cancel
                        </button>
                    </slot>
                </footer>
            </div>

        </div>
    </Transition>
</template>

<style>
.modal-mask {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .4);
    display: grid;
    place-items: center;
}

.modal-container {
    background: white;
    padding: 1rem;
    width: 80vh;
    max-width: 800px;
    border-radius: 7px;
}

.footer {
    border-top: 1px solid #ddd;
    margin-top: 1rem;
    padding-top: 0.5rem;
    font-size: .8rem;

}
</style>