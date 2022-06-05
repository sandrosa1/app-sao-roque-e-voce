import React, {useState, useEffect} from 'react';
import {Switch} from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Globais from './Globais';
import {Buffer} from 'buffer';
import axios from 'axios';

export default function App(props) {
  const [ligado, setLigado] = useState(false);
  const baseURL = 'http://www.racsstudios.com/api/v1/user';
  const [body, setBody] = useState();
  const [confirmacao, setConfirmacao] = useState();
  const [usernome, setUsernome] = useState(null);
  const [usersobrenome, setUsersobrenome] = useState(null);
  const [usertoken, setUsertoken] = useState(null);
  const [usernascimento, setUsernascimento] = useState(null);
  const [useremail, setUseremail] = useState(null);
  const [useridusuario, setUseridusuario] = useState(null);
  const [userdicasrestaurante, setUserdicasrestaurante] = useState(null);
  const [userdicasturismo, setUserdicasturismo] = useState(null);
  const [userdicashospedagem, setUserdicashospedagem] = useState(null);
  const [userativalocalizacao, setUserativalocalizacao] = useState(null);
  const [useralertanovidade, setUseralertanovidade] = useState(null);
  const [useralertaevento, setUseralertaevento] = useState(null);
  const username = Globais.dados?.useremail;
  const password = Globais.dados?.usertoken;
  const auth = Buffer.from(`${username}:${password}`, 'utf8').toString(
    'base64',
  );

  const tipo = props.tipo;
  const valor = props.valor;

  useEffect(() => {
    if (valor == 1) {
      setLigado(true);
    }
  }, []);

  useEffect(() => {
    if (useremail === Globais.dados.useremail) {
      salvar();
    }
  }, [
    useralertaevento,
    useralertanovidade,
    userdicashospedagem,
    userdicasrestaurante,
    userdicasturismo,
    userativalocalizacao
  ]);

  const salvar = async () => {
    console.log('entrou no salvar');
    const usuario = {
      usernome,
      usersobrenome,
      usernascimento,
      usertoken,
      useremail,
      useridusuario,
      userdicasrestaurante,
      userdicasturismo,
      userdicashospedagem,
      userativalocalizacao,
      useralertanovidade,
      useralertaevento,
    };
    console.log(usuario);
    try {
      const jsonValue = JSON.stringify(usuario);
      await AsyncStorage.setItem('usuario', jsonValue);
    } catch (e) {}
  };

  useEffect(() => {
    if (body){
      axios
        .put(baseURL, body, {headers: {Authorization: `Basic ${auth}`}})
        .then(response => {
          console.log('entrou sucesso');
          console.log(response.data);
          setConfirmacao(response.data);
        })
        .catch(error => {});
    };
  }, [body]);

  if (confirmacao) {
    setUsernome(Globais.dados.usernome);
    setUsersobrenome(Globais.dados.usersobrenome);
    setUseremail(Globais.dados.useremail);
    setUsertoken(Globais.dados.usertoken);
    setUseridusuario(Globais.dados.useridusuario);
    setUsernascimento(Globais.dados.usernascimento);
    setUserdicasrestaurante(confirmacao?.dicasRestaurantes);
    setUserdicasturismo(confirmacao?.dicasPontosTuristicos);
    setUserdicashospedagem(confirmacao?.dicasHospedagens);
    setUserativalocalizacao(confirmacao?.ativaLocalizacao);
    setUseralertanovidade(confirmacao?.alertaNovidade);
    setUseralertaevento(confirmacao?.alertaEventos);
    setConfirmacao();
  }

  const toggle = () => {
    console.log(ligado);
    if (ligado == false) {
      console.log('ligou');
      if (tipo == 'alertaNovidade') {
        setBody({alertaNovidade: '1'});
      }
      if (tipo == 'alertaEventos') {
        setBody({alertaEventos: '1'});
      }
      if (tipo == 'dicasHospedagens') {
        setBody({dicasHospedagens: '1'});
      }
      if (tipo == 'dicasPontosTuristicos') {
        setBody({dicasPontosTuristicos: '1'});
      }
      if (tipo == 'dicasRestaurantes') {
        setBody({dicasRestaurantes: '1'});
      }      
      if (tipo == 'ativaLocalizacao') {
        setBody({ativaLocalizacao: '1'});
      }      
    } else {
      console.log('desligou');
      if (tipo == 'alertaNovidade') {
        setBody({alertaNovidade: '0'});
      }
      if (tipo == 'alertaEventos') {
        setBody({alertaEventos: '0'});
      }
      if (tipo == 'dicasHospedagens') {
        setBody({dicasHospedagens: '0'});
      }
      if (tipo == 'dicasPontosTuristicos') {
        setBody({dicasPontosTuristicos: '0'});
      }
      if (tipo == 'dicasRestaurantes') {
        setBody({dicasRestaurantes: '0'});
      } 
      if (tipo == 'ativaLocalizacao') {
        setBody({ativaLocalizacao: '0'});
      }        
    }
    setLigado(!ligado);
  };

  return (
    <Switch
      trackColor={{false: '#414141', true: '#910046'}}
      thumbColor={'#C5C5C5'}
      value={ligado}
      onValueChange={toggle}
    />
  );
}
