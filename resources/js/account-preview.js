export default (register) => ({
    register, email: '', password: '', confirmation: '', scenario: 'success', role: 'user', errors: {}, message: '', success: false,
    reset() {
        this.password = '';
        this.confirmation = '';
        this.errors = {};
        this.message = '';
        this.success = false;
    },
    submit() {
        this.errors = {};
        this.message = '';
        this.success = false;
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email.trim())) this.errors.email = 'Masukkan alamat email yang valid, misalnya rani@example.test.';
        if (this.password.length < 8) this.errors.password = 'Isi kata sandi contoh minimal 8 karakter.';
        if (this.register && this.password !== this.confirmation) this.errors.confirmation = 'Konfirmasi kata sandi belum sama.';
        if (!Object.keys(this.errors).length) {
            if (this.scenario === 'duplicate') this.errors.email = 'Email contoh sudah terdaftar. Silakan masuk.';
            else if (this.scenario === 'wrong') this.errors.password = 'Email atau kata sandi contoh salah. Periksa kembali isian Anda.';
            else if (this.scenario === 'limited') this.message = 'Percobaan masuk contoh dibatasi. Coba lagi nanti atau atur ulang demonstrasi.';
            else {
                this.success = true;
                this.message = this.register ? 'Pendaftaran contoh berhasil. Tidak ada akun yang dibuat.' : 'Masuk contoh berhasil. Tidak ada sesi autentikasi yang dibuat.';
            }
        }
        // Clear submitted passwords; never send them or persist them in browser storage.
        this.password = '';
        this.confirmation = '';
        this.$nextTick(() => {
            const field = Object.keys(this.errors)[0];
            if (field) this.$refs[field].focus();
            else this.$refs.result.focus();
        });
    },
});
