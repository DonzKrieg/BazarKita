const key = 'bazarkita.profile-preview.v1';
const blank = () => ({ category: '', location: '', radius: '', rent: '', start: '', end: '', name: '', min: '', max: '', facilities: [] });
const numeric = value => value !== '' && value !== null && Number.isFinite(Number(value));
export function validateProfile(p) {
    const errors = {};
    if (!['Makanan', 'Minuman', 'Kerajinan', 'Lainnya'].includes(p.category)) errors.category = 'Pilih jenis produk.';
    if (!p.location.trim()) errors.location = 'Isi lokasi asal usaha.';
    if (!numeric(p.radius) || Number(p.radius) <= 0) errors.radius = 'Jarak maksimal harus lebih dari 0 km.';
    if (!numeric(p.rent) || !Number.isSafeInteger(Number(p.rent)) || Number(p.rent) < 0) errors.rent = 'Isi sewa dalam rupiah bulat, minimal 0. Kolom kosong bukan gratis.';
    const date = value => /^\d{4}-\d{2}-\d{2}$/.test(value) && Number.isFinite(Date.parse(value)) && new Date(value).toISOString().slice(0, 10) === value;
    if (!date(p.start)) errors.start = 'Isi tanggal mulai yang valid.';
    if (!date(p.end)) errors.end = 'Isi tanggal selesai yang valid.';
    else if (!errors.start && p.end < p.start) errors.end = 'Tanggal selesai tidak boleh sebelum tanggal mulai.';
    for (const field of ['min', 'max']) {
        if (p[field] !== '' && (!numeric(p[field]) || !Number.isSafeInteger(Number(p[field])) || Number(p[field]) < 0)) errors[field] = 'Isi harga dalam rupiah bulat, minimal 0.';
    }
    if ((p.min === '') !== (p.max === '')) errors[p.min === '' ? 'min' : 'max'] = 'Lengkapi kedua batas harga atau kosongkan keduanya.';
    if (!errors.min && !errors.max && p.min !== '' && Number(p.max) < Number(p.min)) errors.max = 'Harga tertinggi tidak boleh di bawah harga terendah.';
    return errors;
}
export default (fixture, role) => ({
    form: blank(), errors: {}, message: '', extra: false, summary: '',
    init() {
        this.loadFixture();
        try {
            const stored = JSON.parse(sessionStorage.getItem(`${key}.${role}`));
            if (stored && Object.keys(blank()).every(k => k === 'facilities' ? Array.isArray(stored[k]) && stored[k].every(v => typeof v === 'string') : typeof stored[k] === 'string')) {
                this.form = Object.fromEntries(Object.keys(blank()).map(k => [k, stored[k]]));
            }
        } catch { /* A blocked or stale browser store must not prevent editing. */ }
        this.updateSummary();
    },
    loadFixture() {
        this.form = { category: fixture.product_category ?? '', location: fixture.location?.label ?? '', radius: String(fixture.radius_km ?? ''), rent: String(fixture.daily_rent_budget ?? ''), start: fixture.available_dates[0] ?? '', end: fixture.available_dates.at(-1) ?? '', name: fixture.name ?? '', min: String(fixture.product_price_min ?? ''), max: String(fixture.product_price_max ?? ''), facilities: [...fixture.required_facilities] };
        this.errors = {}; this.message = '';
    },
    updateSummary() {
        this.summary = Object.keys(validateProfile(this.form)).length ? 'Profil contoh belum lengkap. Lengkapi Usaha Saya untuk mencoba pilihan personal pada tahap berikutnya.' : `${this.form.category} · ${this.form.location} · ${this.form.radius} km · Rp${Number(this.form.rent).toLocaleString('id-ID')}/hari · ${this.form.start} s.d. ${this.form.end} (WIB)`;
    },
    incomplete() {
        this.form = blank(); this.errors = {}; this.message = 'Contoh profil belum lengkap. Isi lima kelompok wajib di bawah.';
    },
    save() {
        this.errors = validateProfile(this.form);
        if (Object.keys(this.errors).length) {
            if (this.errors.min || this.errors.max) this.extra = true;
            this.message = 'Periksa isian yang ditandai.';
            this.$nextTick(() => this.$el.querySelector(`#profile-${Object.keys(this.errors)[0]}`).focus());
            return;
        }
        try {
            sessionStorage.setItem(`${key}.${role}`, JSON.stringify(this.form));
            this.message = 'Perubahan contoh diterapkan di tab ini. Buka Beranda untuk melihat ringkasannya. Tidak ada data dikirim ke server.';
        } catch {
            this.message = 'Penyimpanan sementara browser tidak tersedia. Isian valid, tetapi perubahan hanya terlihat di halaman ini.';
        }
        this.updateSummary();
        this.$nextTick(() => this.$refs.result.focus());
    },
    reset() {
        try { sessionStorage.removeItem(`${key}.${role}`); } catch { /* Editing remains available. */ }
        this.loadFixture(); this.updateSummary(); this.message = 'Data contoh awal dikembalikan.';
    },
});
