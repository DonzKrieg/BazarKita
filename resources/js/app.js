import Alpine from 'alpinejs';
import bazarBrowser from './bazar-browser';
Alpine.data('bazarBrowser', bazarBrowser);
Alpine.data('correctionPreview', () => ({ reason: '', message: '', submit() { this.message = this.reason.trim() ? 'Contoh laporan diterima untuk antrean pemeriksaan admin. Tidak ada laporan dikirim atau data bazar diubah.' : 'Isi alasan laporan terlebih dahulu.'; if (!this.reason.trim()) this.$refs.reason.focus(); } }));
import accountPreview from './account-preview';
import profilePreview from './profile-preview';

Alpine.data('profilePreview', profilePreview);

Alpine.data('accountPreview', accountPreview);

Alpine.data('dialogPanel', () => ({
    trap(event) {
        const items = [...this.$refs.dialog.querySelectorAll('button:not([disabled]), a[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])')]
            .filter(element => element.getClientRects().length > 0);
        const first = items[0];
        const last = items.at(-1);
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last?.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first?.focus();
        }
    },
}));

Alpine.data('exampleForm', () => ({
    name: '',
    error: '',
    message: '',
    submit() {
        this.error = this.name.trim() ? '' : 'Isi nama usaha terlebih dahulu.';
        this.message = this.error ? '' : 'Contoh isian sudah lengkap. Tidak ada data yang disimpan.';
        if (this.error) this.$el.querySelector('#example-name').focus();
    },
}));

window.Alpine = Alpine;
Alpine.start();
