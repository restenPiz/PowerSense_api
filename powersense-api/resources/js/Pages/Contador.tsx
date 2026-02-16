import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

interface Contador {
    id: number;
    numero_contador: string;
    nome_proprietario: string;
    endereco: string;
    saldo_kwh: number;
}

export default function Contador({ contadores }: { contadores: Contador[] }) {

    return (

        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Contadores
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div>
            <h1>Contadores</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Numero do Contador</th>
                        <th>Nome do Proprietario</th>
                        <th>Endereco</th>
                        <th>Saldo em Kwh</th>
                    </tr>
                </thead>
                <tbody>
                    {contadores.map((contador: Contador) => (
                        <tr key={contador.id}>
                            <td>{contador.numero_contador}</td>
                            <td>{contador.nome_proprietario}</td>
                            <td>{contador.endereco}</td>
                            <td>{contador.saldo_kwh}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
