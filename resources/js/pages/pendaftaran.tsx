import { AnimatePresence, motion, Variants } from 'framer-motion';
import React, { useState } from 'react';

// --- IMPORT DARI /helper/forms.tsx ---
import {
    ConfirmationStep,
    FormComponentProps,
    FormData,
    ParentDataForm,
    PersonalDataForm,
    SchoolDataForm,
} from '../helper/forms'; // Sesuaikan path jika perlu

// --- DEFINISI TYPE (Hanya yang tidak diekspor dari forms.tsx) ---

type StepStatus = 'active' | 'completed' | 'pending';

interface Step {
    number: number;
    label: string;
    status: StepStatus;
}

// --- DATA LANGKAH ---

const initialSteps: Step[] = [
    { number: 1, label: 'Data Diri', status: 'active' },
    { number: 2, label: 'Asal Sekolah', status: 'pending' },
    { number: 3, label: 'Data Orang Tua', status: 'pending' },
    { number: 4, label: 'Konfirmasi', status: 'pending' },
];

const initialFormData: FormData = {
    nama: '',
    dariSiapa: '',
    programPilihan: '',
    tanggalLahir: '',
    tempatLahir: '',
    teleponOrangTua: '',
    jenisKelamin: '',
    alamatPribadi: '',
    namaSekolah: '',
    alamatSekolah: '',
    namaPanjangOrtu: '',
    profesiOrtu: '',
    alamatOrtu: '',
};

// --- KOMPONEN UTAMA ---

export default function Pendaftaran() {
    const [currentStep, setCurrentStep] = useState(1);
    const [formData, setFormData] = useState<FormData>(initialFormData);
    const [steps, setSteps] = useState<Step[]>(initialSteps);

    // Konstanta Warna Tailwind
    const activeColor: string = 'bg-green-500 border-green-500 text-white';
    const pendingColor: string = 'bg-white border-gray-300 text-gray-500';
    const completedColor: string = 'bg-green-500 border-green-500 text-white';

    // Update state form data
    const updateFormData = (fields: Partial<FormData>) => {
        setFormData((prev) => ({ ...prev, ...fields }));
    };

    /**
     * Memperbarui status langkah
     */
    const updateStepStatus = (newStep: number) => {
        setSteps((prevSteps) =>
            prevSteps.map((step) => {
                if (step.number === newStep) {
                    return { ...step, status: 'active' };
                }
                // Jika langkah yang baru lebih besar, langkah yang lama (sebelum newStep) dianggap selesai
                if (step.number < newStep) {
                    return { ...step, status: 'completed' };
                }
                return { ...step, status: 'pending' };
            }),
        );
    };

    /**
     * Pindah ke langkah selanjutnya
     */
    const nextStep = () => {
        if (currentStep < steps.length) {
            const newStep = currentStep + 1;
            setCurrentStep(newStep);
            updateStepStatus(newStep);
        }
    };

    /**
     * Pindah ke langkah sebelumnya
     */
    const prevStep = () => {
        if (currentStep > 1) {
            const newStep = currentStep - 1;
            setCurrentStep(newStep);
            updateStepStatus(newStep);
        }
    };

    // Fungsi styling tetap sama
    const getStepStyle = (status: StepStatus): string => {
        switch (status) {
            case 'active':
                return activeColor + ' shadow-lg ring-4 ring-green-100';
            case 'completed':
                return completedColor;
            case 'pending':
            default:
                return pendingColor;
        }
    };

    const getLineStyle = (index: number): string => {
        if (
            steps[index].status === 'completed' ||
            steps[index].status === 'active'
        ) {
            return 'bg-green-500';
        }
        return 'bg-gray-300';
    };

    // Mapping komponen form menggunakan komponen yang diimpor
    const FormComponents: Record<number, React.FC<FormComponentProps>> = {
        1: PersonalDataForm,
        2: SchoolDataForm,
        3: ParentDataForm,
        4: ConfirmationStep,
    };

    const ActiveForm = FormComponents[currentStep];
    const activeStepLabel: string =
        steps.find((s) => s.number === currentStep)?.label ||
        'Langkah Pendaftaran';

    const componentProps: FormComponentProps = {
        formData,
        updateFormData,
        nextStep,
        prevStep,
    };

    // --- ANIMASI FRAMER MOTION ---
    const pageVariants: Variants = {
        // [1] INITIAL STATE (Component yang MASUK)
        initial: (direction: number) => ({
            opacity: 0,
            // Jika direction positif (Maju), masuk dari kanan (100)
            // Jika direction negatif (Mundur), masuk dari kiri (-100)
            x: direction > 0 ? 100 : -100,
        }),

        // [2] ANIMATE IN (Final state component yang MASUK)
        in: {
            opacity: 1,
            x: 0,
            transition: { type: 'tween', duration: 0.3 },
        },

        // [3] EXIT STATE (Component yang KELUAR)
        out: (direction: number) => ({
            opacity: 0,
            // Jika direction positif (Maju), keluar ke KIRI (-100)
            // Jika direction negatif (Mundur), keluar ke KANAN (100)
            x: direction > 0 ? -100 : 100, // LOGIKA DIPERBAIKI DI SINI
            transition: { type: 'tween', duration: 0.3 },
        }),
    };

    // Simpan langkah sebelumnya untuk menentukan arah transisi
    const [prevStepState, setPrevStepState] = useState(currentStep);
    const direction = currentStep > prevStepState ? 1 : -1;
    React.useEffect(() => {
        setPrevStepState(currentStep);
    }, [currentStep]);

    return (
        <div className="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
            <div className="mx-auto max-w-7xl">
                {/* Judul Utama */}
                <div className="mb-8 text-center md:mb-12 lg:mb-16">
                    <div className="bg-gradient-to-r from-[#0bdf00] to-blue-500 bg-clip-text text-2xl font-extrabold tracking-tight text-transparent sm:text-3xl lg:text-4xl">
                        PORTAL PENDAFTARAN
                    </div>
                    <div className="mt-1 text-lg font-bold text-gray-700 sm:text-xl lg:text-2xl">
                        PONDOK PESANTREN MODERN ARRAHMAH
                    </div>
                </div>

                <div className="fixed bottom-5 -left-5 z-50 flex w-full items-end justify-end">
                    <a href="https://api.whatsapp.com/send/?phone=6285850180698&text&type=phone_number&app_absent=0">
                        <button className="text-green flex items-center rounded-full border border-green-500 bg-green-50 px-5 font-bold text-green-500 transition-all hover:scale-110 hover:cursor-pointer hover:bg-green-100">
                            <img
                                src="/images/wa.webp"
                                className="size-10"
                                alt="whatsapp"
                            />
                            Hubungi Admin
                        </button>
                    </a>
                </div>

                <div className="mx-auto w-full max-w-6xl rounded-xl border border-gray-100 bg-white p-4 shadow-lg sm:p-6 md:p-8 lg:p-12 xl:p-16">
                    {/* --- Steps Indicator --- */}
                    <div className="relative mb-8 md:mb-12 lg:mb-16">
                        {/* Horizontal Line Connector - Sembunyikan di mobile */}
                        <div className="absolute top-1/4 right-0 left-0 hidden h-0.5 -translate-y-1/2 transform justify-between px-4 sm:flex md:px-6 lg:px-10">
                            {steps.slice(0, -1).map((_step, index) => (
                                <div
                                    key={`line-${index}`}
                                    className={`h-0.5 w-full ${getLineStyle(index)}`}
                                    style={{ margin: '0 10px' }}
                                />
                            ))}
                        </div>

                        {/* Steps - Responsive Grid */}
                        <div className="grid grid-cols-2 gap-4 sm:grid-cols-4 sm:gap-0">
                            {steps.map((step) => (
                                <div
                                    key={step.number}
                                    className="z-10 flex flex-col items-center"
                                >
                                    {/* Step Circle - Ukuran responsif */}
                                    <div
                                        className={`inline-flex h-8 w-8 items-center justify-center rounded-full border-2 text-sm font-semibold transition-all duration-300 ease-in-out sm:h-10 sm:w-10 sm:text-base md:h-12 md:w-12 md:text-lg ${getStepStyle(step.status)}`}
                                    >
                                        {step.number}
                                    </div>
                                    {/* Step Label - Sembunyikan di mobile sangat kecil, tampilkan di mobile */}
                                    <div
                                        className={`mt-2 text-center text-xs font-medium sm:text-sm md:mt-3 md:text-base ${step.status === 'active' ? 'font-bold text-green-600' : 'text-gray-600'}`}
                                    >
                                        {/* Label pendek untuk mobile, label lengkap untuk desktop */}
                                        <span className="hidden sm:inline">
                                            {step.label}
                                        </span>
                                        <span className="sm:hidden">
                                            {step.number === 1 && 'Data Diri'}
                                            {step.number === 2 && 'Sekolah'}
                                            {step.number === 3 && 'Ortu'}
                                            {step.number === 4 && 'Konfirmasi'}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* --- Form Content with Animation --- */}
                    <div className="mt-6 border-t pt-6 md:mt-8 md:pt-8">
                        <h3 className="mb-4 text-center text-lg font-semibold text-gray-800 sm:text-xl md:text-2xl">
                            Formulir Pendaftaran - {activeStepLabel}
                        </h3>

                        <div className="relative overflow-hidden">
                            {' '}
                            {/* Wrapper untuk AnimatePresence */}
                            <AnimatePresence initial={false} mode="wait">
                                <motion.div
                                    key={currentStep} // Kunci unik untuk memicu animasi saat currentStep berubah
                                    custom={direction}
                                    variants={pageVariants}
                                    initial="initial"
                                    animate="in"
                                    exit="out"
                                    layout
                                    className="w-full"
                                >
                                    <ActiveForm {...componentProps} />
                                </motion.div>
                            </AnimatePresence>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
