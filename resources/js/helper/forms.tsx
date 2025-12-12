import { Textarea } from '@headlessui/react';
import React from 'react';

// --- INTERFACE & TYPES (Diekspor untuk digunakan di Pendaftaran.tsx) ---

export interface FormData {
    nama: string;
    tanggalLahir: string;
    teleponOrangTua: string;
    alamatPribadi: string;
    tempatLahir: string;
    namaSekolah: string;
    alamatSekolah: string;
    namaPanjangOrtu: string;
    profesiOrtu: string;
    alamatOrtu: string;
    programPilihan: string;
    dariSiapa: string;
}

export interface FormComponentProps {
    formData: FormData;
    updateFormData: (fields: Partial<FormData>) => void;
    nextStep: () => void;
    prevStep: () => void;
}

// --- KOMPONEN INPUT ---

const Input: React.FC<
    React.InputHTMLAttributes<HTMLInputElement> & {
        label: string;
        name: keyof FormData;
    }
> = ({ label, name, ...rest }) => (
    <div className="mb-4">
        <label
            htmlFor={name}
            className="block text-left text-sm font-medium text-gray-700"
        >
            {label}
        </label>
        <input
            id={name}
            name={name}
            {...rest}
            className="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
        />
    </div>
);

// --- KOMPONEN TEXTAREA ---

const TextArea: React.FC<
    React.TextareaHTMLAttributes<HTMLTextAreaElement> & {
        label: string;
        name: keyof FormData;
    }
> = ({ label, name, onChange, ...rest }) => (
    <div className="mb-4">
        <label
            htmlFor={name}
            className="block text-left text-sm font-medium text-gray-700"
        >
            {label}
        </label>
        <textarea
            id={name}
            name={name}
            onChange={onChange}
            {...rest}
            className="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
        />
    </div>
);

// --- LANGKAH 1: Data Diri 👤 ---
export const PersonalDataForm: React.FC<FormComponentProps> = ({
    formData,
    updateFormData,
    nextStep,
}) => {
    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>,
    ) => {
        const { name, value } = e.target;
        updateFormData({
            [name as keyof FormData]: value,
        } as Partial<FormData>);
    };

    return (
        <div className="rounded-lg bg-white p-4">
            <Input
                label="Nama Lengkap Calon Santri"
                placeholder="Contoh: Bintan"
                name="nama"
                value={formData.nama}
                onChange={handleChange}
                required
            />
            <Input
                label="Tanggal Lahir"
                name="tanggalLahir"
                type="date"
                value={formData.tanggalLahir}
                onChange={handleChange}
                required
            />
            <TextArea
                label="Tempat Lahir"
                name="tempatLahir"
                value={formData.tempatLahir}
                onChange={handleChange}
                placeholder="Contoh: Bandar Lampung"
                required
            />
            <TextArea
                label="Alamat Lengkap Saat Ini"
                name="alamatPribadi"
                value={formData.alamatPribadi}
                onChange={handleChange}
                placeholder="Contoh: Jl. Raya No. 123, RT. 01 RW. 01, Kec. Bandar Lampung, Kab. Bandar Lampung"
                required
            />
            <div className="mt-6 flex justify-end">
                <button
                    onClick={nextStep}
                    className="rounded-lg bg-green-600 px-6 py-2 font-semibold text-white shadow-md transition duration-150 hover:bg-green-700"
                >
                    Selanjutnya
                </button>
            </div>
        </div>
    );
};

const RadioGroup: React.FC<{
    label: string;
    name: keyof FormData;
    value: string;
    onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
    options: Array<{ value: string; label: string }>;
    required?: boolean;
}> = ({ label, name, value, onChange, options, required = false }) => (
    <div className="mb-4">
        <div className="block text-left text-sm font-medium text-gray-700">
            {label} {required && <span className="text-red-500">*</span>}
        </div>
        <div className="mt-2 space-y-2 grid grid-cols-2">
            {options.map((option) => (
                <div key={option.value} className="flex items-center">
                    <input
                        type="radio"
                        id={`${name}-${option.value}`}
                        name={name}
                        value={option.value}
                        checked={value === option.value}
                        onChange={onChange}
                        className="h-4 w-4 border-red-500 text-green-600 bg-red-500 focus:ring-green-500 accent-green-500"
                        required={required}
                    />
                    <label
                        htmlFor={`${name}-${option.value}`}
                        className="ml-3 block text-sm font-medium text-gray-700"
                    >
                        {option.label}
                    </label>
                </div>
            ))}
        </div>
    </div>
);

// --- LANGKAH 2: Asal Sekolah 🏫 ---
export const SchoolDataForm: React.FC<FormComponentProps> = ({
    formData,
    updateFormData,
    nextStep,
    prevStep,
}) => {
    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>,
    ) => {
        const { name, value } = e.target;
        updateFormData({
            [name as keyof FormData]: value,
        } as Partial<FormData>);
    };

    const handleRadioChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        updateFormData({
            [name as keyof FormData]: value,
        } as Partial<FormData>);
    };

    const programOptions = [
        { value: 'reguler', label: 'Reguler' },
        { value: 'intensif', label: 'Intensif' },
    ];

    return (
        <div className="rounded-lg bg-white p-4">
            <Input
                label="Nama Sekolah (SD/MI/SMP/MTs)"
                name="namaSekolah"
                value={formData.namaSekolah}
                onChange={handleChange}
                placeholder="Contoh: SD Negeri 1 Bandar Lampung"
                required
            />
            <TextArea
                label="Alamat Sekolah Asal"
                name="alamatSekolah"
                value={formData.alamatSekolah}
                placeholder="Contoh: Jl. Raya No. 123, RT. 01 RW. 01, Kec. Bandar Lampung, Kab. Bandar Lampung"
                onChange={handleChange}
                required
            />

            {/* Program Pilihan Sekolah - Radio Button */}
            <RadioGroup
                label="Program Pilihan Sekolah"
                name="programPilihan"
                value={formData.programPilihan}
                onChange={handleRadioChange}
                options={programOptions}
                required
            />

            <Input
                label="Dari Mana/Siapa anda tahu pondok kami?"
                name="dariSiapa"
                value={formData.dariSiapa}
                onChange={handleChange}
                placeholder="Contoh: Orang tua, teman, media"
                required
            />

            <div className="mt-6 flex justify-between">
                <button
                    onClick={prevStep}
                    className="rounded-lg bg-gray-300 px-6 py-2 font-semibold text-gray-800 transition duration-150 hover:bg-gray-400"
                >
                    Sebelumnya
                </button>
                <button
                    onClick={nextStep}
                    className="rounded-lg bg-green-600 px-6 py-2 font-semibold text-white shadow-md transition duration-150 hover:bg-green-700"
                >
                    Selanjutnya
                </button>
            </div>
        </div>
    );
};

// --- LANGKAH 3: Data Orang Tua 👨‍👩‍👧‍👦 ---
export const ParentDataForm: React.FC<FormComponentProps> = ({
    formData,
    updateFormData,
    nextStep,
    prevStep,
}) => {
    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>,
    ) => {
        const { name, value } = e.target;
        updateFormData({
            [name as keyof FormData]: value,
        } as Partial<FormData>);
    };

    return (
        <div className="rounded-lg bg-white p-4">
            <Input
                label="Nama Panjang Ayah/Ibu/Wali"
                name="namaPanjangOrtu"
                value={formData.namaPanjangOrtu}
                placeholder="Contoh: Budi Setiawan"
                onChange={handleChange}
                required
            />
            <Input
                label="Profesi Orang Tua"
                name="profesiOrtu"
                value={formData.profesiOrtu}
                placeholder="Contoh: PNS"
                onChange={handleChange}
                required
            />
            <TextArea
                label="Alamat Lengkap Orang Tua (Disamakan dengan KTP/KK)"
                name="alamatOrtu"
                value={formData.alamatOrtu}
                placeholder="Contoh: Jl. Raya No. 123, RT. 01 RW. 01, Kec. Bandar Lampung, Kab. Bandar Lampung"
                onChange={handleChange}
                required
            />

            <Input
                label="Nomor Telepon Orang Tua"
                name="teleponOrangTua"
                value={formData.teleponOrangTua}
                type="number"
                placeholder="Contoh: 08123456789"
                onChange={handleChange}
                required
            />

            <div className="mt-6 flex justify-between">
                <button
                    onClick={prevStep}
                    className="rounded-lg bg-gray-300 px-6 py-2 font-semibold text-gray-800 transition duration-150 hover:bg-gray-400"
                >
                    Sebelumnya
                </button>
                <button
                    onClick={nextStep}
                    className="rounded-lg bg-green-600 px-6 py-2 font-semibold text-white shadow-md transition duration-150 hover:bg-green-700"
                >
                    Selanjutnya
                </button>
            </div>
        </div>
    );
};

// --- LANGKAH 4: Konfirmasi 🎉 ---
export const ConfirmationStep: React.FC<FormComponentProps> = ({
    formData,
    prevStep,
}) => {
    const handleSubmit = () => {
        console.log('Data Pendaftaran Siap Disubmit:', formData);
        alert('Pendaftaran berhasil! Silakan cek konsol untuk melihat data.');
    };

    const SummaryField: React.FC<{
        label: string;
        value: string;
        className?: string;
    }> = ({ label, value, className = '' }) => (
        <div className={`p-2 ${className}`}>
            <span className="font-medium text-gray-700">{label}:</span>
            <div className="mt-1 text-gray-900">{value || <span className="text-gray-400">-</span>}</div>
        </div>
    );

    // Fungsi untuk mendapatkan label program
    const getProgramLabel = (value: string) => {
        switch(value) {
            case 'reguler': return 'Reguler';
            case 'intensif': return 'Intensif';
            default: return value || '-';
        }
    };

    return (
        <div className="rounded-lg bg-white p-6 shadow-lg">
            <h4 className="mb-6 text-center text-2xl font-bold text-green-700">
                📋 Konfirmasi Data Pendaftaran
            </h4>
            <p className="mb-8 text-center text-gray-600">
                Mohon periksa kembali semua data yang telah Anda masukkan sebelum submit.
            </p>

            {/* Tampilan Ringkasan Data */}
            <div className="mb-8 rounded-lg border border-gray-200 bg-gray-50 p-4">
                <div className="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    {/* Data Santri */}
                    <div className="rounded-lg bg-white p-4 shadow-sm">
                        <h5 className="mb-3 border-b pb-2 text-lg font-semibold text-green-700">
                            👤 Data Santri
                        </h5>
                        <SummaryField label="Nama Lengkap" value={formData.nama} />
                        <SummaryField label="Tanggal Lahir" value={formData.tanggalLahir} />
                        <SummaryField label="Tempat Lahir" value={formData.tempatLahir} />
                        <SummaryField 
                            label="Alamat Lengkap" 
                            value={formData.alamatPribadi} 
                            className="col-span-2"
                        />
                    </div>

                    {/* Data Sekolah */}
                    <div className="rounded-lg bg-white p-4 shadow-sm">
                        <h5 className="mb-3 border-b pb-2 text-lg font-semibold text-blue-700">
                            🏫 Data Sekolah
                        </h5>
                        <SummaryField label="Nama Sekolah Asal" value={formData.namaSekolah} />
                        <SummaryField 
                            label="Alamat Sekolah" 
                            value={formData.alamatSekolah} 
                            className="col-span-2"
                        />
                        <SummaryField 
                            label="Program Pilihan" 
                            value={getProgramLabel(formData.programPilihan)} 
                        />
                        <SummaryField 
                            label="Mengetahui dari" 
                            value={formData.dariSiapa} 
                        />
                    </div>

                    {/* Data Orang Tua */}
                    <div className="rounded-lg bg-white p-4 shadow-sm">
                        <h5 className="mb-3 border-b pb-2 text-lg font-semibold text-purple-700">
                            👨‍👩‍👧‍👦 Data Orang Tua
                        </h5>
                        <SummaryField label="Nama Lengkap" value={formData.namaPanjangOrtu} />
                        <SummaryField label="Profesi" value={formData.profesiOrtu} />
                        <SummaryField label="Telepon" value={formData.teleponOrangTua} />
                        <SummaryField 
                            label="Alamat (KTP/KK)" 
                            value={formData.alamatOrtu} 
                            className="col-span-2"
                        />
                    </div>
                </div>
            </div>

            {/* Notes */}
            <div className="mb-8 rounded-lg border border-yellow-200 bg-yellow-50 p-4">
                <div className="flex items-start">
                    <div className="mr-3 text-yellow-600">
                        <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clipRule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h6 className="font-semibold text-yellow-800">Perhatian:</h6>
                        <p className="text-sm text-yellow-700">
                            Pastikan semua data sudah benar. Data yang sudah disubmit tidak dapat diubah.
                        </p>
                    </div>
                </div>
            </div>

            {/* Tombol Aksi */}
            <div className="flex flex-col justify-between gap-4 sm:flex-row">
                <button
                    onClick={prevStep}
                    className="rounded-lg bg-gray-200 px-6 py-3 font-semibold text-gray-800 transition duration-150 hover:bg-gray-300 sm:px-8"
                >
                    ↩ Kembali ke Data Orang Tua
                </button>
                <div className="flex flex-col gap-4 sm:flex-row">
                    <button
                        onClick={() => window.print()}
                        className="rounded-lg bg-amber-500 px-6 py-3 font-semibold text-white transition duration-150 hover:bg-amber-600 sm:px-8"
                    >
                        🖨️ Cetak Data
                    </button>
                    <button
                        onClick={handleSubmit}
                        className="rounded-lg bg-green-600 px-6 py-3 font-semibold text-white shadow-md transition duration-150 hover:bg-green-700 sm:px-8"
                    >
                        ✅ Submit Pendaftaran
                    </button>
                </div>
            </div>
        </div>
    );
};