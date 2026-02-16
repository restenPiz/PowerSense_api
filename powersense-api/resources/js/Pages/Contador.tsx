import React, { useEffect, useState } from 'react';
import axios from 'axios';

interface Contador {
    id: number;
    numero_contador: string;
    nome_proprietario: string;
    endereco: string;
    saldo_kwh: number;
}

export default function Contador({ contadores }: { contadores: Contador[] }) {

    return (
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
    );
}
