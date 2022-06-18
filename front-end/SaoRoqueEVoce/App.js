import React from 'react';
import {View} from 'react-native';
import {NavigationContainer} from '@react-navigation/native';
import {createNativeStackNavigator} from '@react-navigation/native-stack';
import Index from './pages/home/Index';
import Home from './pages/home/Home';
import Login from './pages/login/Login';
import Cadastro from './pages/login/Cadastro';
import TermosPolitica from './pages/login/TermosPolitica';
import EsqueciSenha from './pages/login/EsqueciSenha';
import Segmento from './pages/segmento/Segmento';
import Servicos from './pages/servicos/Servicos';
import QuemSomos from './pages/quemsomos/QuemSomos';
import Configuracao from './pages/configuracao/Configuracao';
import Perfil from './pages/configuracao/Perfil';
import Ajustes from './pages/configuracao/Ajustes';
import Notificacao from './pages/configuracao/Notificacao';
import Comentarios from './pages/configuracao/Comentarios';
import PaginaDetalhes from './componentes/PaginaDetalhes';
import PaginaDetalhesComentario from './componentes/PaginaDetalhesComentario';

const Stack = createNativeStackNavigator();

function App() {
  return (
      <NavigationContainer>
        <Stack.Navigator
          initialRouteName="Index"
          screenOptions={{headerShown: false}}>
          <Stack.Screen name="Index" component={Index} />
          <Stack.Screen name="Login" component={Login} />
          <Stack.Screen name="Cadastro" component={Cadastro} />
          <Stack.Screen name="TermosPolitica" component={TermosPolitica} />
          <Stack.Screen name="EsqueciSenha" component={EsqueciSenha} />
          <Stack.Screen name="Segmento" component={Segmento} />
          <Stack.Screen name="Servicos" component={Servicos} />
          <Stack.Screen name="QuemSomos" component={QuemSomos} />
          <Stack.Screen name="Configuracao" component={Configuracao} />
          <Stack.Screen name="Perfil" component={Perfil} />
          <Stack.Screen name="Ajustes" component={Ajustes} />
          <Stack.Screen name="Notificacao" component={Notificacao} />
          <Stack.Screen name="Comentarios" component={Comentarios} />
          <Stack.Screen name="PaginaDetalhes" component={PaginaDetalhes} />
          <Stack.Screen
            name="PaginaDetalhesComentario"
            component={PaginaDetalhesComentario}
          />
          <Stack.Screen name="Home" component={Home} />
        </Stack.Navigator>
      </NavigationContainer>
  );
}

export default App;
