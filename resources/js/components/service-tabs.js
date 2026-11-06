/**
 * Abas de serviços acessíveis (padrão WAI-ARIA Tabs, ativação automática).
 */
export default (ids) => ({
    ids,
    active: ids[0],

    select(id) {
        if (this.ids.includes(id)) {
            this.active = id;
        }
    },

    onKeydown(event) {
        // Setas laterais e verticais: no celular as abas ficam empilhadas.
        const keys = ['ArrowRight', 'ArrowDown', 'ArrowLeft', 'ArrowUp', 'Home', 'End'];
        if (!keys.includes(event.key)) return;
        event.preventDefault();

        const index = this.ids.indexOf(this.active);
        const last = this.ids.length - 1;
        const next = {
            ArrowRight: index === last ? 0 : index + 1,
            ArrowDown: index === last ? 0 : index + 1,
            ArrowLeft: index === 0 ? last : index - 1,
            ArrowUp: index === 0 ? last : index - 1,
            Home: 0,
            End: last,
        }[event.key];

        this.active = this.ids[next];
        this.$nextTick(() => document.getElementById(`tab-${this.active}`)?.focus());
    },
});
