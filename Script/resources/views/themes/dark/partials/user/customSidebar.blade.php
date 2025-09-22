<div class="custom-sidebar">
    <div class="radio-input">
        <label class="label">
            <input type="radio" id="value-1" {{ (auth()->user()->active_dashboard == 'daybreak') ? 'checked' : '' }} name="dashboard" value="daybreak" />
            <p class="text">@lang('Daybreak')</p>
        </label>
        <label class="label">
            <input type="radio" id="value-2" {{ (auth()->user()->active_dashboard == 'nightfall') ? 'checked' : '' }}  name="dashboard" value="nightfall" />
            <p class="text">@lang('Nightfall')</p>
        </label>
    </div>
    <button type="button" class="toggle-theme-button">
        <i class="fa-regular fa-gear"></i>
    </button>
</div>

<style>
    .custom-sidebar {
        width: 250px;
        background-color: var(--bg-color1);
        position: fixed;
        top: 100px;
        left: 0;
        box-shadow: var(--shadow3);
        padding: 20px;
        z-index: 9999;
        border-radius: 0 20px 20px 0;
        border: 1px solid var(--border-color1);
        left: -250px;
        transition: var(--transition);
    }
    .custom-sidebar.active {
        left: 0;
    }
    .custom-sidebar .toggle-theme-button {
        position: absolute;
        width: 45px;
        height: 45px;
        background-color: rgb(var(--primary-color));
        color: rgb(var(--white));
        display: flex;
        align-items: center;
        justify-content: center;
        right: -45px;
        top: 50%;
        transform: translateY(-50%);
        box-shadow: var(--shadow3);
        border-radius: 0 15px 15px 0;
        font-size: 18px;
    }
    .custom-sidebar .radio-input {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .custom-sidebar .radio-input * {
        box-sizing: border-box;
        padding: 0;
        margin: 0;
    }
    .custom-sidebar .radio-input label {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 0px 20px;
        width: 100%;
        cursor: pointer;
        height: 50px;
        position: relative;
    }
    .custom-sidebar .radio-input label::before {
        position: absolute;
        content: "";
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 45px;
        z-index: -1;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        border-radius: 10px;
        border: 2px solid var(--border-color1);
    }
    .custom-sidebar .radio-input label:hover::before {
        transition: all 0.2s ease;
        background-color: rgb(var(--primary-color), 0.1);
    }
    .custom-sidebar .radio-input .label:has(input:checked)::before {
        border-color: rgb(var(--primary-color));
        height: 50px;
    }
    .custom-sidebar .radio-input .label .text {
        color: rgb(var(--heading-color));
    }
    .custom-sidebar .radio-input .label input[type=radio] {
        background-color: var(--lime-gray);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .custom-sidebar .radio-input .label input[type=radio]:checked {
        background-color: rgb(var(--primary-color));
        animation: pulse 0.7s forwards;
    }
    .custom-sidebar .radio-input .label input[type=radio]:before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        transition: all 0.1s cubic-bezier(0.165, 0.84, 0.44, 1);
        background-color: var(--bg-color1);
        transform: scale(0);
    }
    .custom-sidebar .radio-input .label input[type=radio]:checked::before {
        transform: scale(1);
    }
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(255, 255, 255, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
        }
    }

</style>
<script>
    const customSidebar = document.querySelector('.custom-sidebar');
    const toggleSidebarBtn = document.querySelector('.toggle-theme-button');

    toggleSidebarBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        customSidebar.classList.toggle('active');
    });

    window.addEventListener('click', (e) => {
        if (!customSidebar.contains(e.target) && !toggleSidebarBtn.contains(e.target)) {
            customSidebar.classList.remove('active');
        }
    });

    document.querySelectorAll('input[name="dashboard"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            const selectedValue = this.value;

            axios.post("{{ route('user.change.dashboard') }}", {
                dashboard: selectedValue
            })
                .then(response => {
                    window.location.reload();
                })
                .catch(error => {
                    Notiflix.Notify.failure('Failed to update dashboard preference.');
                });
        });
    });
</script>
