{{--
    ============================================================
    AUTH STYLES PARTIAL — resources/views/partials/auth/styless.blade.php
    PENTING: File ini TIDAK pakai @push/@endpush di dalamnya.
    Di-include dari view dengan: @include('partials.auth.styless')
    ============================================================
--}}
<style>
body {
    background-color: #f0f6ff;
    background-image:
        radial-gradient(circle at 15% 25%, rgba(37,99,235,0.08) 0%, transparent 45%),
        radial-gradient(circle at 85% 75%, rgba(59,130,246,0.06) 0%, transparent 45%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.auth-container {
    width: 100%;
    max-width: 900px;
    background: #ffffff;
    border-radius: 24px;
    overflow: hidden;
    display: flex;
    box-shadow:
        0 0 0 1px rgba(0,0,0,0.05),
        0 4px 6px rgba(0,0,0,0.04),
        0 20px 50px rgba(0,0,0,0.1);
    animation: authFadeUp 0.5s ease both;
}

@keyframes authFadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.auth-left { flex: 1; padding: 48px 44px; display: flex; flex-direction: column; }

.auth-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 36px; }
.auth-brand-icon {
    width: 42px; height: 42px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 12px rgba(37,99,235,0.3); flex-shrink: 0;
}
.auth-brand-name { font-size: 17px; font-weight: 800; color: #111; display: block; line-height: 1.2; letter-spacing: -0.3px; }
.auth-brand-sub  { font-size: 11px; font-weight: 600; color: #9ca3af; letter-spacing: 0.8px; text-transform: uppercase; }

.auth-intro    { margin-bottom: 28px; }
.auth-title    { font-size: 28px; font-weight: 800; color: #0f0f0f; letter-spacing: -0.7px; margin: 0 0 6px; }
.auth-subtitle { font-size: 14px; color: #9ca3af; margin: 0; line-height: 1.5; }

.auth-alert { display: flex; align-items: flex-start; gap: 9px; padding: 12px 14px; border-radius: 12px; font-size: 13.5px; font-weight: 500; margin-bottom: 18px; }
.auth-alert--success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.auth-alert--error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

.auth-form  { flex: 1; }
.auth-field { margin-bottom: 18px; }
.auth-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 7px; }

.auth-input-wrap { position: relative; }
.auth-input-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: #d1d5db; pointer-events: none; transition: color 0.15s; display: flex; align-items: center;
}
.auth-input-wrap:focus-within .auth-input-icon { color: #2563eb; }

.auth-input {
    width: 100%; padding: 12px 42px;
    border: 1.5px solid #e5e7eb; border-radius: 12px;
    font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: #111; background: #fafafa; outline: none; transition: all 0.15s; box-sizing: border-box;
}
.auth-input:focus        { border-color: #2563eb; background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
.auth-input.is-error     { border-color: #f87171; }
.auth-input::placeholder { color: #c4c4c4; }

.auth-input-toggle {
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: #9ca3af;
    display: flex; align-items: center; padding: 0; transition: color 0.15s;
}
.auth-input-toggle:hover { color: #2563eb; }
.auth-field-error { font-size: 12px; color: #ef4444; margin-top: 5px; display: flex; align-items: center; gap: 4px; }

.auth-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
.auth-check { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #555; cursor: pointer; user-select: none; }
.auth-check input[type="checkbox"] { accent-color: #2563eb; width: 15px; height: 15px; cursor: pointer; }
.auth-forgot { font-size: 13px; font-weight: 600; color: #2563eb; text-decoration: none; transition: color 0.15s; }
.auth-forgot:hover { color: #1d4ed8; text-decoration: underline; }

.auth-btn-primary {
    width: 100%; padding: 13px;
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #fff; border: none; border-radius: 12px;
    font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(37,99,235,0.3);
}
.auth-btn-primary:hover  { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(37,99,235,0.4); }
.auth-btn-primary:active { transform: translateY(0); }

.auth-divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
.auth-divider-line { flex: 1; height: 1px; background: #f0f0f0; }
.auth-divider-text { font-size: 11px; font-weight: 600; color: #d1d5db; text-transform: uppercase; letter-spacing: 0.8px; }

.auth-btn-google {
    width: 100%; padding: 12px; background: #fff; color: #374151;
    border: 1.5px solid #e5e7eb; border-radius: 12px;
    font-size: 14px; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: all 0.15s;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    text-decoration: none; box-sizing: border-box;
}
.auth-btn-google:hover { background: #f9fafb; border-color: #d1d5db; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }

.auth-form-footer {
    text-align: center; margin-top: 24px; padding-top: 20px;
    border-top: 1px solid #f3f4f6; font-size: 13.5px; color: #9ca3af;
}
.auth-link { color: #2563eb; font-weight: 700; text-decoration: none; transition: color 0.15s; }
.auth-link:hover { color: #1d4ed8; text-decoration: underline; }

.auth-right {
    width: 380px; flex-shrink: 0;
    background: linear-gradient(145deg, #1d4ed8 0%, #2563eb 40%, #3b82f6 100%);
    padding: 44px 36px;
    display: flex; flex-direction: column; align-items: center;
    position: relative; overflow: hidden;
}
.auth-right-dots {
    position: absolute; inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px);
    background-size: 22px 22px; pointer-events: none;
}
.auth-right-brand {
    display: flex; align-items: center; gap: 10px;
    background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2); border-radius: 16px;
    padding: 12px 18px; align-self: stretch; margin-bottom: 28px; position: relative; z-index: 1;
}
.auth-right-brand-logo {
    width: 40px; height: 40px; background: rgba(255,255,255,0.2);
    border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.auth-right-brand-name { font-size: 15px; font-weight: 700; color: #fff; line-height: 1.2; }
.auth-right-brand-sub  { font-size: 11px; color: rgba(255,255,255,0.65); font-weight: 500; }

.auth-right-illustration { flex: 1; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; }
.auth-right-svg { width: 100%; max-width: 300px; filter: drop-shadow(0 16px 32px rgba(0,0,0,0.2)); }
.auth-right-caption { text-align: center; margin-bottom: 20px; position: relative; z-index: 1; }
.auth-right-title { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin: 0 0 8px; }
.auth-right-desc  { font-size: 13.5px; color: rgba(255,255,255,0.72); margin: 0; line-height: 1.6; }
.auth-right-pills { display: flex; flex-direction: column; gap: 8px; align-self: stretch; position: relative; z-index: 1; }
.auth-pill {
    display: flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.13); border: 1px solid rgba(255,255,255,0.18);
    border-radius: 10px; padding: 9px 14px; font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.9);
}

@media (max-width: 768px) {
    .auth-container { flex-direction: column; max-width: 440px; }
    .auth-right { width: 100%; padding: 32px 28px; }
    .auth-right-illustration { display: none; }
    .auth-right-pills { flex-direction: row; flex-wrap: wrap; }
    .auth-left { padding: 36px 28px; }
}

@media (max-width: 480px) {
    body { padding: 16px; }
    .auth-left  { padding: 28px 20px; }
    .auth-right { padding: 24px 20px; }
    .auth-title { font-size: 24px; }
}
</style>