@extends('layouts.app')
@section('title','Lavozimlar')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 page-header-title">Lavozimlar</h2>
        <p class="mb-0 page-header-sub">Bog‘cha tizimidagi barcha lavozimlar kategoriya bo‘yicha</p>
    </div>
</div>

<div class="row g-4">
    {{-- Management --}}
    <div class="col-lg-6">
        <div class="card role-card bg-gradient">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="card-title role-title mb-0">Management (Boshqaruv)</h2>
                    <span class="role-badge">4 ta lavozim</span>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Admin (admin)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Drektor (drektor)</div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Metodist (metodist)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Meneger (meneger)</div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="card-title role-title mb-0">Education-Care (Tarbiyachilar)</h2>
                    <span class="role-badge">2 ta lavozim</span>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Tarbiyachi (tarbiyachi)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Yordamchi tarbiyachi (yordam_tarbiyachi)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Education-Teacher --}}
    <div class="col-lg-6">
        <div class="card role-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="card-title role-title mb-0">Education-Teacher (O'qituvchilar)</h2>
                    <span class="role-badge">7 ta lavozim</span>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Psixolog (psixolog)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Defektolog (defektolog)</div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Logoped (logoped)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Ingliz tili (ingliz_tili)</div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Rus tili (rus_tili)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Jismoniy tarbiya (jismoniy_tarbiya)</div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="role-item">Rasm,Sanat (rasm_sanat)</div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="card-title role-title mb-0">Service (Xizmat ko'rsatish)</h2>
                    <span class="role-badge">6 ta lavozim</span>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Hamshira (hamshira)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Qo'riqchi (qoriqchi)</div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Farrosh (farrosh)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Kir yuvuvchi (kir-yuvuvchi)</div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="role-item">Bosh oshpaz (bosh_oshpaz)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Yordamchi oshpaz (yordam_oshpaz)</div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="card-title role-title mb-0">Extra (Qo'shimcha)</h2>
                    <span class="role-badge">4 ta lavozim</span>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <div class="role-item"  style="text-align: left">Marketing muxandisi (marketing_muhandis)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">SMM Muhandisi (smm_muhandis)</div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="role-item"  style="text-align: left">Fotograf (fotograf)</div>
                    </div>
                    <div class="col-lg-6 mb-2" style="text-align: right">
                        <div class="role-item">Texnik hodim (texnik)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
