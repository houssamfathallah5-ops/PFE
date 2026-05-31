@extends('layouts.app')

@section('content')
<div style="display:flex;align-items:center;justify-content:center;min-height:calc(100vh - 180px)">
    <div style="width:100%;max-width:440px;background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:24px;padding:48px;box-shadow:0 20px 40px rgba(0,0,0,0.4)">
        <div style="text-align:center;margin-bottom:32px">
            <div style="width:60px;height:60px;background:linear-gradient(135deg, var(--accent), #536dfe);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;box-shadow:0 8px 16px var(--accent-dim)">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1 style="font-size:28px;font-weight:800;letter-spacing:-1px;margin-bottom:8px">{{ __('Create account') }}</h1>
            <p style="color:var(--text-muted);font-size:14px">{{ __('Join Melodix and start listening') }}</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div style="margin-bottom:20px">
                <label style="display:block;font-size:12px;font-weight:700;color:var(--text-faint);text-transform:uppercase;margin-bottom:8px">{{ __('Name') }}</label>
                <input type="text" name="name" required style="width:100%;background:rgba(255,255,255,0.05);border:1px solid var(--border);padding:14px 16px;border-radius:12px;color:#fff;font-size:14px;outline:none;transition:all .2s" onfocus="this.style.border='1px solid var(--accent)';this.style.background='rgba(255,255,255,0.08)'" onblur="this.style.border='1px solid var(--border)';this.style.background='rgba(255,255,255,0.05)'">
                @error('name')<div style="color:#ff5252;font-size:12px;margin-top:6px">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:20px">
                <label style="display:block;font-size:12px;font-weight:700;color:var(--text-faint);text-transform:uppercase;margin-bottom:8px">{{ __('Email') }}</label>
                <input type="email" name="email" required style="width:100%;background:rgba(255,255,255,0.05);border:1px solid var(--border);padding:14px 16px;border-radius:12px;color:#fff;font-size:14px;outline:none;transition:all .2s" onfocus="this.style.border='1px solid var(--accent)';this.style.background='rgba(255,255,255,0.08)'" onblur="this.style.border='1px solid var(--border)';this.style.background='rgba(255,255,255,0.05)'">
                @error('email')<div style="color:#ff5252;font-size:12px;margin-top:6px">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:20px">
                <label style="display:block;font-size:12px;font-weight:700;color:var(--text-faint);text-transform:uppercase;margin-bottom:8px">{{ __('Register As') }}</label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <label style="cursor:pointer;position:relative">
                        <input type="radio" name="role" value="listener" checked style="position:absolute;opacity:0;width:0;height:0" id="role_listener">
                        <div id="card_listener" style="border:2px solid var(--accent);background:rgba(124,77,255,0.1);padding:16px;border-radius:16px;text-align:center;transition:all 0.3s">
                            <i class="fas fa-headphones" style="font-size:24px;color:var(--accent);margin-bottom:8px;display:block"></i>
                            <span style="font-weight:700;font-size:14px;color:#fff">{{ __('Listener') }}</span>
                        </div>
                    </label>
                    <label style="cursor:pointer;position:relative">
                        <input type="radio" name="role" value="artist" style="position:absolute;opacity:0;width:0;height:0" id="role_artist">
                        <div id="card_artist" style="border:2px solid var(--border);background:rgba(255,255,255,0.02);padding:16px;border-radius:16px;text-align:center;transition:all 0.3s">
                            <i class="fas fa-microphone" style="font-size:24px;color:var(--text-muted);margin-bottom:8px;display:block"></i>
                            <span style="font-weight:700;font-size:14px;color:var(--text-muted)">{{ __('Artist') }}</span>
                        </div>
                    </label>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:32px">
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;color:var(--text-faint);text-transform:uppercase;margin-bottom:8px">{{ __('Password') }}</label>
                    <input type="password" name="password" required style="width:100%;background:rgba(255,255,255,0.05);border:1px solid var(--border);padding:14px 16px;border-radius:12px;color:#fff;font-size:14px;outline:none;transition:all .2s" onfocus="this.style.border='1px solid var(--accent)';this.style.background='rgba(255,255,255,0.08)'" onblur="this.style.border='1px solid var(--border)';this.style.background='rgba(255,255,255,0.05)'">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:700;color:var(--text-faint);text-transform:uppercase;margin-bottom:8px">{{ __('Confirm') }}</label>
                    <input type="password" name="password_confirmation" required style="width:100%;background:rgba(255,255,255,0.05);border:1px solid var(--border);padding:14px 16px;border-radius:12px;color:#fff;font-size:14px;outline:none;transition:all .2s" onfocus="this.style.border='1px solid var(--accent)';this.style.background='rgba(255,255,255,0.08)'" onblur="this.style.border='1px solid var(--border)';this.style.background='rgba(255,255,255,0.05)'">
                </div>
            </div>
            <button type="submit" style="width:100%;background:var(--accent);color:#000;font-weight:700;padding:16px;border-radius:12px;border:none;cursor:pointer;font-size:16px;transition:all .3s;box-shadow:0 8px 16px var(--accent-dim)" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 24px var(--accent-dim)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 16px var(--accent-dim)'">
                {{ __('Register') }}
            </button>
        </form>

        <div style="text-align:center;margin-top:32px;font-size:14px;color:var(--text-muted)">
            {{ __("Already have an account?") }} <a href="{{ route('login') }}" style="color:var(--accent);font-weight:600">{{ __('Login') }}</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleListener = document.getElementById('role_listener');
    const roleArtist = document.getElementById('role_artist');
    const cardListener = document.getElementById('card_listener');
    const cardArtist = document.getElementById('card_artist');

    roleListener.addEventListener('change', function() {
        if(this.checked) {
            cardListener.style.border = '2px solid var(--accent)';
            cardListener.style.background = 'rgba(124,77,255,0.1)';
            cardListener.querySelector('i').style.color = 'var(--accent)';
            cardListener.querySelector('span').style.color = '#fff';
            
            cardArtist.style.border = '2px solid var(--border)';
            cardArtist.style.background = 'rgba(255,255,255,0.02)';
            cardArtist.querySelector('i').style.color = 'var(--text-muted)';
            cardArtist.querySelector('span').style.color = 'var(--text-muted)';
        }
    });

    roleArtist.addEventListener('change', function() {
        if(this.checked) {
            cardArtist.style.border = '2px solid var(--accent)';
            cardArtist.style.background = 'rgba(124,77,255,0.1)';
            cardArtist.querySelector('i').style.color = 'var(--accent)';
            cardArtist.querySelector('span').style.color = '#fff';
            
            cardListener.style.border = '2px solid var(--border)';
            cardListener.style.background = 'rgba(255,255,255,0.02)';
            cardListener.querySelector('i').style.color = 'var(--text-muted)';
            cardListener.querySelector('span').style.color = 'var(--text-muted)';
        }
    });
});
</script>
@endsection
