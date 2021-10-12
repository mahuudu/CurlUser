import userApi from 'api/userApi';

const {createSlice, createAsyncThunk} = require('@reduxjs/toolkit');


export const register = createAsyncThunk( 
    'users/register',
    async (payload,{ rejectWithValue }) => {

        const response  = await userApi.register(payload);
        if(response ){
          localStorage.setItem('access_token', JSON.stringify(response ['idToken']));
          localStorage.setItem('user',JSON.stringify(response['email']));
        }
        return response.data;

    }
  )

  export const login = createAsyncThunk( 
    'users/login',
    async (payload,{ rejectWithValue }) => {

        const response  = await userApi.login(payload);
        if(response ){
          localStorage.setItem('access_token', JSON.stringify(response ['idToken']));
          localStorage.setItem('user',JSON.stringify(response['email']));
        }
        return response.data;

    }
  )

const userSlice = createSlice({
    name : 'user',
    initialState : {
      current : {},
      settings :{},
    },
    reducers : {},
    extraReducers:  {
      [register.fulfilled] : (state, action) => {
        state.current = action.payload;
      },
      [login.fulfilled] : (state, action) => {
        state.current = action.payload;
      },
    },
});

const {reducer} = userSlice;

export default reducer;