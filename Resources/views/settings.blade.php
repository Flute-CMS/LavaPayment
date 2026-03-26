@php
    $settings = $gateway ? $gateway->getSettings() : [];
    if (empty($settings)) {
        $settings = [
            'shopId' => '',
            'secretKey' => '',
            'additionalKey' => '',
        ];
    }
@endphp

<x-alert type="info" withClose="false" class="mb-0">
    Для настройки платёжной системы Lava вам потребуются <strong>Shop ID</strong>, <strong>Секретный ключ</strong>
    и <strong>Дополнительный ключ</strong> из
    <a href="https://lava.ru" target="_blank">личного кабинета Lava</a>.
</x-alert>

<x-forms.field>
    <x-forms.label for="settings__shopId" required>Shop ID:</x-forms.label>
    <x-fields.input name="settings__shopId" id="settings__shopId"
        value="{{ request()->input('settings__shopId', $settings['shopId']) }}" required
        placeholder="UUID идентификатор проекта" />
</x-forms.field>

<x-forms.field>
    <x-forms.label for="settings__secretKey" required>Секретный ключ:</x-forms.label>
    <x-fields.input name="settings__secretKey" id="settings__secretKey" type="password"
        value="{{ request()->input('settings__secretKey', $settings['secretKey']) }}" required
        placeholder="Секретный ключ для подписи запросов" />
</x-forms.field>

<x-forms.field>
    <x-forms.label for="settings__additionalKey" required>Дополнительный ключ:</x-forms.label>
    <x-fields.input name="settings__additionalKey" id="settings__additionalKey" type="password"
        value="{{ request()->input('settings__additionalKey', $settings['additionalKey']) }}" required
        placeholder="Дополнительный ключ для проверки webhook'ов" />
</x-forms.field>
