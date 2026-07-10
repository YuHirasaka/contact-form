import { useEffect, useState } from 'react';
import { fetchCategories, submitContact } from '../api/contactApi';
import './ContactForm.css';

const initialForm = {
  last_name: '',
  first_name: '',
  gender: '',
  email: '',
  tel: ['', '', ''],
  address: '',
  building: '',
  category_id: '',
  detail: '',
};

/**
 * お問い合わせフォーム（React版）
 *
 * Blade版の contact/index.blade.php に相当する「画面担当」コンポーネントです。
 * バリデーション・DB保存は Laravel API が担当します。
 */
export default function ContactForm() {
  const [form, setForm] = useState(initialForm);
  const [categories, setCategories] = useState([]);
  const [errors, setErrors] = useState({});
  const [successMessage, setSuccessMessage] = useState('');
  const [isSubmitting, setIsSubmitting] = useState(false);

  useEffect(() => {
    fetchCategories()
      .then(setCategories)
      .catch(() => {
        setErrors({ _form: ['カテゴリの取得に失敗しました'] });
      });
  }, []);

  const updateField = (name, value) => {
    setForm((prev) => ({ ...prev, [name]: value }));
    setErrors((prev) => {
      const next = { ...prev };
      delete next[name];
      delete next._form;
      return next;
    });
  };

  const updateTel = (index, value) => {
    setForm((prev) => {
      const tel = [...prev.tel];
      tel[index] = value;
      return { ...prev, tel };
    });
    setErrors((prev) => {
      const next = { ...prev };
      delete next.tel;
      delete next['tel.0'];
      delete next['tel.1'];
      delete next['tel.2'];
      return next;
    });
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    setSuccessMessage('');
    setIsSubmitting(true);

    const payload = {
      ...form,
      gender: form.gender ? Number(form.gender) : '',
      category_id: form.category_id ? Number(form.category_id) : '',
    };

    const result = await submitContact(payload);
    setIsSubmitting(false);

    if (result.success) {
      setForm(initialForm);
      setErrors({});
      setSuccessMessage(result.message);
      return;
    }

    setErrors(result.errors);
  };

  const fieldError = (name) => {
    if (errors[name]?.[0]) return errors[name][0];
    if (name === 'tel' && errors['tel.0']?.[0]) return errors['tel.0'][0];
    if (name === 'tel' && errors['tel.1']?.[0]) return errors['tel.1'][0];
    if (name === 'tel' && errors['tel.2']?.[0]) return errors['tel.2'][0];
    return '';
  };

  if (successMessage) {
    return (
      <div className="contact-form">
        <div className="contact-form__heading">
          <h1>Contact</h1>
        </div>
        <p className="contact-form__success">{successMessage}</p>
        <button
          type="button"
          className="form__button"
          onClick={() => setSuccessMessage('')}
        >
          もう一度送信する
        </button>
      </div>
    );
  }

  return (
    <div className="contact-form">
      <div className="contact-form__heading">
        <h1>Contact</h1>
        <p className="contact-form__note">（React + API 版）</p>
      </div>

      {errors._form && (
        <p className="form__error form__error--global">{errors._form[0]}</p>
      )}

      <form className="form" onSubmit={handleSubmit} noValidate>
        <div className="form__group">
          <div className="form__group-title">
            <span className="form__label">お名前</span>
            <span className="form__label--required">※</span>
          </div>
          <div className="form__group-content">
            <div className="form__field form__field--name">
              <div className="form__item">
                <input
                  className="form__item-input"
                  type="text"
                  placeholder="例:山田"
                  value={form.last_name}
                  onChange={(e) => updateField('last_name', e.target.value)}
                />
                {fieldError('last_name') && (
                  <div className="form__error">{fieldError('last_name')}</div>
                )}
              </div>
              <div className="form__item">
                <input
                  className="form__item-input"
                  type="text"
                  placeholder="例:太郎"
                  value={form.first_name}
                  onChange={(e) => updateField('first_name', e.target.value)}
                />
                {fieldError('first_name') && (
                  <div className="form__error">{fieldError('first_name')}</div>
                )}
              </div>
            </div>
          </div>
        </div>

        <div className="form__group">
          <div className="form__group-title">
            <span className="form__label">性別</span>
            <span className="form__label--required">※</span>
          </div>
          <div className="form__group-content">
            <div className="form__radio">
              {[
                { value: '1', label: '男性' },
                { value: '2', label: '女性' },
                { value: '3', label: 'その他' },
              ].map(({ value, label }) => (
                <label key={value} className="form__radio-item">
                  <input
                    type="radio"
                    name="gender"
                    value={value}
                    checked={form.gender === value}
                    onChange={(e) => updateField('gender', e.target.value)}
                  />
                  {label}
                </label>
              ))}
            </div>
            {fieldError('gender') && (
              <div className="form__error">{fieldError('gender')}</div>
            )}
          </div>
        </div>

        <div className="form__group">
          <div className="form__group-title">
            <span className="form__label">メールアドレス</span>
            <span className="form__label--required">※</span>
          </div>
          <div className="form__group-content">
            <input
              className="form__item-input"
              type="email"
              placeholder="例:test@example.com"
              value={form.email}
              onChange={(e) => updateField('email', e.target.value)}
            />
            {fieldError('email') && (
              <div className="form__error">{fieldError('email')}</div>
            )}
          </div>
        </div>

        <div className="form__group">
          <div className="form__group-title">
            <span className="form__label">電話番号</span>
            <span className="form__label--required">※</span>
          </div>
          <div className="form__group-content">
            <div className="form__field form__field--tel">
              {[0, 1, 2].map((index) => (
                <span key={index} className="form__tel-part">
                  {index > 0 && <span className="form__sep">-</span>}
                  <input
                    className="form__item-input"
                    type="tel"
                    inputMode="numeric"
                    value={form.tel[index]}
                    onChange={(e) => updateTel(index, e.target.value)}
                  />
                </span>
              ))}
            </div>
            {fieldError('tel') && (
              <div className="form__error">{fieldError('tel')}</div>
            )}
          </div>
        </div>

        <div className="form__group">
          <div className="form__group-title">
            <span className="form__label">住所</span>
            <span className="form__label--required">※</span>
          </div>
          <div className="form__group-content">
            <input
              className="form__item-input"
              type="text"
              placeholder="例:東京都渋谷区千駄ヶ谷1-2-3"
              value={form.address}
              onChange={(e) => updateField('address', e.target.value)}
            />
            {fieldError('address') && (
              <div className="form__error">{fieldError('address')}</div>
            )}
          </div>
        </div>

        <div className="form__group">
          <div className="form__group-title">
            <span className="form__label">建物名</span>
          </div>
          <div className="form__group-content">
            <input
              className="form__item-input"
              type="text"
              placeholder="例:千駄ヶ谷マンション101"
              value={form.building}
              onChange={(e) => updateField('building', e.target.value)}
            />
          </div>
        </div>

        <div className="form__group">
          <div className="form__group-title">
            <span className="form__label">お問い合わせの種類</span>
            <span className="form__label--required">※</span>
          </div>
          <div className="form__group-content">
            <select
              className="form__item-select"
              value={form.category_id}
              onChange={(e) => updateField('category_id', e.target.value)}
            >
              <option value="" disabled>
                選択してください
              </option>
              {categories.map((category) => (
                <option key={category.id} value={category.id}>
                  {category.content}
                </option>
              ))}
            </select>
            {fieldError('category_id') && (
              <div className="form__error">{fieldError('category_id')}</div>
            )}
          </div>
        </div>

        <div className="form__group">
          <div className="form__group-title">
            <span className="form__label">お問い合わせ内容</span>
            <span className="form__label--required">※</span>
          </div>
          <div className="form__group-content">
            <textarea
              className="form__item-textarea"
              placeholder="お問い合わせ内容をご記載ください"
              value={form.detail}
              onChange={(e) => updateField('detail', e.target.value)}
            />
            {fieldError('detail') && (
              <div className="form__error">{fieldError('detail')}</div>
            )}
          </div>
        </div>

        <div className="form__actions">
          <button
            type="submit"
            className="form__button form__button--submit"
            disabled={isSubmitting}
          >
            {isSubmitting ? '送信中...' : '送信する'}
          </button>
        </div>
      </form>
    </div>
  );
}
