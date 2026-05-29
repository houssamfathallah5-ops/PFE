@extends('layouts.app')

@section('content')
<div style="display:flex;align-items:center;justify-content:center;min-height:calc(100vh - 180px)">
    <div style="width:100%;max-width:400px;background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:24px;padding:48px;box-shadow:0 20px 40px rgba(0,0,0,0.4)">
        <div style="text-align:center;margin-bottom:32px">
            <div style="width:60px;height:60px;background:linear-gradient(135deg, var(--accent), #536dfe);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;box-shadow:0 8px 16px var(--accent-dim)">
                <i class="fas fa-music"></i>
            </div>
            <h1 style="font-size:28px;font-weight:800;letter-spacing:-1px;margin-bottom:8px">{{ __('Welcome back') }}</h1>
            <p style="color:var(--text-muted);font-size:14px">{{ __('Login to your Melodix account') }}</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div style="margin-bottom:20px">
                <label style="display:block;font-size:12px;font-weight:700;color:var(--text-faint);text-transform:uppercase;margin-bottom:8px">{{ __('Email') }}</label>
                <input type="email" name="email" required style="width:100%;background:rgba(255,255,255,0.05);border:1px solid var(--border);padding:14px 16px;border-radius:12px;color:#fff;font-size:14px;outline:none;transition:all .2s" onfocus="this.style.border='1px solid var(--accent)';this.style.background='rgba(255,255,255,0.08)'" onblur="this.style.border='1px solid var(--border)';this.style.background='rgba(255,255,255,0.05)'">
                @error('email')<div style="color:#ff5252;font-size:12px;margin-top:6px">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:32px">
                <label style="display:block;font-size:12px;font-weight:700;color:var(--text-faint);text-transform:uppercase;margin-bottom:8px">{{ __('Password') }}</label>
                <input type="password" name="password" required style="width:100%;background:rgba(255,255,255,0.05);border:1px solid var(--border);padding:14px 16px;border-radius:12px;color:#fff;font-size:14px;outline:none;transition:all .2s" onfocus="this.style.border='1px solid var(--accent)';this.style.background='rgba(255,255,255,0.08)'" onblur="this.style.border='1px solid var(--border)';this.style.background='rgba(255,255,255,0.05)'">
            </div>
            <button type="submit" style="width:100%;background:var(--accent);color:#000;font-weight:700;padding:16px;border-radius:12px;border:none;cursor:pointer;font-size:16px;transition:all .3s;box-shadow:0 8px 16px var(--accent-dim)" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 24px var(--accent-dim)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 16px var(--accent-dim)'">
                {{ __('Login') }}
            </button>
        </form>

        <div style="text-align:center;margin-top:32px;font-size:14px;color:var(--text-muted)">
            {{ __("Don't have an account?") }} <a href="{{ route('register') }}" style="color:var(--accent);font-weight:600">{{ __('Register') }}</a>
        </div>
    </div>
</div>
@endsection
