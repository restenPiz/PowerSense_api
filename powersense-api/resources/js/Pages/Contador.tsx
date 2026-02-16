import React, { useEffect, useState } from 'react';
import axios from 'axios';

interface Contador {
    id: number;
    nombre: string;
    valor: number;
    estado: string;
    fecha_actualizacion: string;
}

export default function Contador() {
    const [contadores, setContadores] = useState<Contador[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        fetchContadores();
    }, []);

    const fetchContadores = async () => {
        try {
            setLoading(true);
            const response = await axios.get('/api/contadores');
            setContadores(response.data);
            setError(null);
        } catch (err) {
            setError('Error fetching contadores');
            console.error(err);
        } finally {
            setLoading(false);
        }
    };

    if (loading) return <div>Loading...</div>;
    if (error) return <div>{error}</div>;

    return (
        <div>
            <h1>Contadores</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Valor</th>
                        <th>Estado</th>
                        <th>Última Actualización</th>
                    </tr>
                </thead>
                <tbody>
                    {contadores.map((contador) => (
                        <tr key={contador.id}>
                            <td>{contador.id}</td>
                            <td>{contador.nombre}</td>
                            <td>{contador.valor}</td>
                            <td>{contador.estado}</td>
                            <td>{contador.fecha_actualizacion}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}